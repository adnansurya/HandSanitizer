
#include "DHT.h"
#include <NewPing.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

#define DHTPIN 14     // Digital pin connected to the DHT sensor
#define TRIGGER_PIN  13  // Arduino pin tied to trigger pin on the ultrasonic sensor.
#define ECHO_PIN     12  // Arduino pin tied to echo pin on the ultrasonic sensor.
#define MAX_DISTANCE 200
#define LIMIT_DISTANCE 10

#define WATER_PIN A0

//#define DHTTYPE DHT11   // DHT 11
#define DHTTYPE DHT22   // DHT 22  (AM2302), AM2321
//#define DHTTYPE DHT21   // DHT 21 (AM2301)

#define POMPA_PIN 2

DHT dht(DHTPIN, DHTTYPE);
NewPing sonar(TRIGGER_PIN, ECHO_PIN, MAX_DISTANCE); 

const char* ssid = "Cafetuli";
const char* password = "Hening07";

void setup() {
  Serial.begin(9600);
  Serial.println(F("DHTxx test OK!"));

  dht.begin();

  pinMode(POMPA_PIN, OUTPUT);
  digitalWrite(POMPA_PIN, HIGH);

   WiFi.begin(ssid, password);
 Serial.print("Connecting..");
  while (WiFi.status() != WL_CONNECTED) {
 
    delay(1000);
     Serial.print("."); //status saat mengkoneksikan
    
  }
  Serial.println("IP Address:"); //alamat ip lokal
    Serial.println(WiFi.localIP());
}

void loop() {
  digitalWrite(POMPA_PIN, HIGH);
  Serial.print("Ping: ");
  String pingStr = String(sonar.ping_cm());
  int pingCm = pingStr.toInt();
  Serial.println(pingStr + " cm");
  // Wait a few seconds between measurements.

  if(pingCm < LIMIT_DISTANCE  && pingCm > 0){

     digitalWrite(POMPA_PIN, LOW);
    
    int adcWater = analogRead(WATER_PIN);
    Serial.print("Air : ");
    Serial.println(adcWater);
    
    float t = dht.readTemperature();

    // Check if any reads failed and exit early (to try again).
    if (isnan(t)) {
      Serial.println(F("Failed to read from DHT sensor!"));
      return;
    }
  
    Serial.print(t);
    Serial.println(F("°C "));

     konekURL("http://192.168.1.45/handsanitizer/api/add_data.php?suhu=" + String(t) + "&cairan=" + String(adcWater));  
   
    delay(2000);
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
