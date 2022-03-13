
#include <Adafruit_MLX90614.h>


#include <NewPing.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>


#define TRIGGER_PIN  D5  // Arduino pin tied to trigger pin on the ultrasonic sensor.
#define ECHO_PIN     D6  // Arduino pin tied to echo pin on the ultrasonic sensor.
#define MAX_DISTANCE 200
#define LIMIT_DISTANCE 5


#define WATER_PIN A0
#define POMPA_PIN D4

Adafruit_MLX90614 mlx = Adafruit_MLX90614();
NewPing sonar(TRIGGER_PIN, ECHO_PIN, MAX_DISTANCE); 

const char* ssid = "HOLOGRAM";
const char* password = "copastanpabatas";

int airPenuh = 900;
int airKosong = 650;

//String webhost = "http://192.168.1.5/handsanitizer/";
String webhost = "http://protohandsanitizer.000webhostapp.com/";

void setup() {
  Serial.begin(9600);


   if (!mlx.begin()) {
    Serial.println("Error connecting to MLX sensor. Check wiring.");
    while (1);
  };

  Serial.print("Emissivity = "); Serial.println(mlx.readEmissivity());
  Serial.println("================================================");


WiFi.begin(ssid, password);
 Serial.print("Connecting..");
   Serial.print("Connecting..");
  while (WiFi.status() != WL_CONNECTED) {
 
    delay(1000);
     Serial.print("."); //status saat mengkoneksikan
    
  }
  Serial.println("IP Address:"); //alamat ip lokal
    Serial.println(WiFi.localIP());

  pinMode(POMPA_PIN, OUTPUT);
  digitalWrite(POMPA_PIN, HIGH);
}

void loop() {
  digitalWrite(POMPA_PIN, HIGH);
  Serial.print("Ping: ");
  String pingStr = String(sonar.ping_cm());
  int pingCm = pingStr.toInt();
  Serial.println(pingStr + " cm");
  // Wait a few seconds between measurements.
 float t = mlx.readObjectTempC();

    // Check if any reads failed and exit early (to try again).
    if (isnan(t) || t > 1000.0) {
      Serial.println(F("Failed to read from  sensor!"));
      return;
    }
    
  
    Serial.print(t);
    Serial.println(F("°C "));

     int adcWater = analogRead(WATER_PIN);
    Serial.print("Air : ");
    Serial.println(adcWater);
  if(pingCm < LIMIT_DISTANCE  && pingCm > 0){

       digitalWrite(POMPA_PIN, LOW);
        delay(1000);
        digitalWrite(POMPA_PIN, HIGH);
    konekURL(webhost + "api/add_data.php?suhu=" + String(t) + "&cairan=" + String(adcWater) + "&max=" + String(airPenuh)+ "&min=" + String(airKosong));      
  }

  // Read temperature as Celsius (the default)
  
  
  delay(50); 
}

void konekURL(String url){
if (WiFi.status() == WL_CONNECTED) { //Check WiFi connection status

    WiFiClient client;
    HTTPClient http;  //Declare an object of class HTTPClient
 
     if (http.begin(client, url)) {  // HTTP


//      Serial.print("[HTTP] GET...\n");
      // start connection and send HTTP header
      int httpCode = http.GET();

      // httpCode will be negative on error
      if (httpCode > 0) {
        // HTTP header has been send and Server response header has been handled
//        Serial.printf("[HTTP] GET... code: %d\n", httpCode);

        // file found at server
        if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {
          String payload = http.getString();
          Serial.print(payload);
          Serial.print('\n');
        }
      } else {
        Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
      }

      http.end();
    } else {
      Serial.printf("[HTTP} Unable to connect\n");
    }
  }
  delay(1000);
}
