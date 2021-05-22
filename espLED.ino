/*
  Copyright (C) 2021 Benjamin J. Meyer

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <https://www.gnu.org/licenses/>.

*/
// setting PWM properties
const int freq = 5000;
const int resolution = 8;

// Import required libraries
#include "WiFi.h"
#include "ESPAsyncWebServer.h"
#include "SPIFFS.h"

// Replace with your network credentials
const char* ssid = "LEDNet";
const char* password = "22302992835916202786";

// Create AsyncWebServer object on port 80
AsyncWebServer server(80);

//current colot storage
int currentR = 0;
int currentG = 0;
int currentB = 0;
int currentA = 0;




// Replaces placeholder with LED state value
String processor(const String& var){
  if(var == "CurSliR"){
    return String(currentR);
  } if(var == "CurSliG"){
    return String(currentG);
  } if(var == "CurSliB"){
    return String(currentB);
  }  if(var == "CurSliA"){
    return String(currentA);
  }

  if(var == "CurR"){
    return String(currentR);
  } if(var == "CurG"){
    return String(currentG);
  } if(var == "CurB"){
    return String(currentB);
  } if(var == "CurA"){
    return String(currentA);
  }


  return String();
}





void setup(){
  Serial.begin(115200);

  // configure LED PWM functionalitites
  ledcSetup(0, freq, resolution);
  ledcSetup(1, freq, resolution);
  ledcSetup(2, freq, resolution);
  ledcSetup(3, freq, resolution);

  // attach the channel to the GPIO to be controlled
  ledcAttachPin(16, 0);
  ledcAttachPin(17, 1);
  ledcAttachPin(18, 2);
  ledcAttachPin(19, 3);

  // Initialize SPIFFS
  if(!SPIFFS.begin(true)){
    Serial.println("An Error has occurred while mounting SPIFFS");
    return;
  }

  // Connect to Wi-Fi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    Serial.println("Connecting to WiFi..");
    Serial.println(WiFi.status());
    delay(1000);
  }

  // Print ESP32 Local IP Address
  Serial.println(WiFi.localIP());

  // Route for root / web page
  server.on("/", HTTP_GET, [](AsyncWebServerRequest *request){
    request->send(SPIFFS, "/index.html", String(), false, processor);
  });

  // Route to load style.css file
  server.on("/colors.json", HTTP_GET, [](AsyncWebServerRequest *request){
    request->send(SPIFFS, "/colors.json", "application/json");
  });








  // Route to set
  server.on("/set", HTTP_GET, [](AsyncWebServerRequest *request){



    AsyncWebParameter* r = request->getParam(0);
    AsyncWebParameter* g = request->getParam(1);
    AsyncWebParameter* b = request->getParam(2);



    Serial.print("Param value: ");
    Serial.println("R: " + r->value() + ", G: " + g->value() + ", B: " + b->value());

    ledcWrite(0, r->value().toInt());
    ledcWrite(1, g->value().toInt());
    ledcWrite(2, b->value().toInt());

    currentR = r->value().toInt();
    currentG = g->value().toInt();
    currentB = b->value().toInt();

    if (request->params() > 3) {
      AsyncWebParameter* a = request->getParam(3);
      ledcWrite(3, a->value().toInt());
      currentA = a->value().toInt();
    }



    //ledcWrite(ledChannel, p->value().toInt());


    request->send(SPIFFS, "/index.html", String(), false, processor);
  });


  // Route to set
  server.on("/setA", HTTP_GET, [](AsyncWebServerRequest *request){

  AsyncWebParameter* a = request->getParam(0);
  ledcWrite(3, a->value().toInt());
  currentA = a->value().toInt();

  request->send(SPIFFS, "/index.html", String(), false, processor);
  });

  server.on("/saveColor", HTTP_GET, [](AsyncWebServerRequest *request){

    AsyncWebParameter* json = request->getParam(0);

    Serial.print("Trying to add new COLOR!");

    File file = SPIFFS.open("/colors.json", FILE_WRITE);

    if (file.print(String(json->value()))) {
        Serial.println("File was written");
    } else {
        Serial.println("File write failed");
    }

    request->send(SPIFFS, "/index.html", String(), false, processor);

  });

  // Start server
  server.begin();
}







void loop(){

}
