
#include <Adafruit_MLX90614.h> //inisialisasi library sensor suhu Infrared  
#include <NewPing.h> //inisialisasi libary sensor ultrasonic

//inisialisasi library board ESP8266
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>


//mendefinisikan pin yang terhubung dengan sensor ultrasonic
#define TRIGGER_PIN  D5  
#define ECHO_PIN     D6  
//mendefinisikan jarak maksimal dan batas jarak minimum sensor ultrasonic
#define MAX_DISTANCE 200
#define LIMIT_DISTANCE 5

//mendefinisikan pin yang terhubung dengan water sensor
#define WATER_PIN A0
//mendefinisikan pin yang terhubung dengan relay untuk menyalakan pompa
#define POMPA_PIN D4

Adafruit_MLX90614 mlx = Adafruit_MLX90614(); //mendeklarasikan objek sensor suhu
NewPing sonar(TRIGGER_PIN, ECHO_PIN, MAX_DISTANCE);  //mendeklarasikan objek sensor ultrasonic

//mendefinisikan variabel SSID dan Password jaringan WiFi
const char* ssid = "HOLOGRAM";
const char* password = "copastanpabatas";

//mendefinisikan nilai ADC saat air kosong dan penuh
int airPenuh = 900;
int airKosong = 650;

//mendefinisikan alamat web yang akan digunakan
//String webhost = "http://192.168.1.5/handsanitizer/";
String webhost = "http://protohandsanitizer.000webhostapp.com/";

void setup() {
  
  Serial.begin(9600); //memulai komunikasi serial 9600 BAUD


  //inisialisasi objek sensor suhu
   if (!mlx.begin()) {
    Serial.println("Error connecting to MLX sensor. Check wiring.");
    while (1);
  };
  Serial.print("Emissivity = "); Serial.println(mlx.readEmissivity());
  Serial.println("================================================");


//inisialisasi koneksi ke jaringan WiFi
WiFi.begin(ssid, password);
 Serial.print("Connecting..");
   Serial.print("Connecting..");
  while (WiFi.status() != WL_CONNECTED) {
 
    delay(1000);
     Serial.print("."); //status saat mengkoneksikan
    
  }
  Serial.println("IP Address:"); //alamat ip lokal
    Serial.println(WiFi.localIP());

  
  pinMode(POMPA_PIN, OUTPUT); //mendeklarasikan pin Relay Pompa sebagai output
  digitalWrite(POMPA_PIN, HIGH); //menonaktifkan relay pompa (active low)
}

void loop() {
  digitalWrite(POMPA_PIN, HIGH);
  Serial.print("Ping: ");
   //mengukur jarak dengan sensor ultrasonic
  String pingStr = String(sonar.ping_cm());
  int pingCm = pingStr.toInt();
  Serial.println(pingStr + " cm");

   //mengukur temperatur dalam satuan derajat celcius dengan sensor suhu
   float t = mlx.readObjectTempC();
    // Check if any reads failed and exit early (to try again).
    if (isnan(t) || t > 1000.0) {
      Serial.println(F("Failed to read from  sensor!"));
      return;
    }    
    Serial.print(t);
    Serial.println(F("°C "));


    //mengukur nilai ADC pada water sensor
     int adcWater = analogRead(WATER_PIN);
    Serial.print("Air : ");
    Serial.println(adcWater);
    
    if(pingCm < LIMIT_DISTANCE  && pingCm > 0){ //jika jarak berada dibawah batas minimum,

       digitalWrite(POMPA_PIN, LOW); //maka pompa menyala
        delay(1000); //jeda 1 detik
        digitalWrite(POMPA_PIN, HIGH); //pompa berhenti kembali

        //selanjutnya mengirim data suhu, nilai adc saat ini, nilai adc penuh, dan nilai adc saat air kosong
    konekURL(webhost + "api/add_data.php?suhu=" + String(t) + "&cairan=" + String(adcWater) + "&max=" + String(airPenuh)+ "&min=" + String(airKosong));      /
  }
  
  
  delay(50); 
}

void konekURL(String url){
  
if (WiFi.status() == WL_CONNECTED) { //jika jaringan Wifi dalam keadaan tersambung

    WiFiClient client;
    HTTPClient http; 
 
     if (http.begin(client, url)) {  // HTTP

      // mengirim HTTP Header
      int httpCode = http.GET();

      // httpCode will be negative on error
      if (httpCode > 0) {
   

        
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
