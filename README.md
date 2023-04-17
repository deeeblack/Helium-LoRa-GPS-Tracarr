# LoRa-GPS-Tracarr
Helium LoRaWan GP Tracker data into Tracarr


## STEP 1.
On-board LoRaWAN tracker to Helium console.
  - Either Get DevEUI, AppEUI and App Key from Helium console and configure LoRaWan Tracker to suit, or insert from Tracker to Console. Usually I just generate them from     Console and change my device.
  - Set Region of the device to either AU915-6 or AS923-1 for Dual Plan in Australia, **(This is going to change as at 18th April 23 for Helium, they will revert back to      AU915 FSB2.)**
  - Confirm Join/Accept request successful by looking at your device in console or via serial connection to device.


## STEP 2.
Link your Device to a Decoder (Function) and then an Integration.
  - Create a new 'Çustom' Decoder in the 'Functions' area of Console.
  - Copy the following snippet into the 'Custom Script' section of the decoder

```
function Decoder(bytes, port) { 
    var sensor = {};    
    sensor.latitude  = (bytes[0] | bytes[1] << 8 | bytes[2] << 16 | bytes[3] << 24 | (bytes[3] & 0x80 ? 0xFF << 24 : 0)) / 100000;   
    sensor.longitude = (bytes[4] | bytes[5] << 8 | bytes[6] << 16 | bytes[7] << 24 | (bytes[7] & 0x80 ? 0xFF << 24 : 0)) / 100000;   
    sensor.altitude  = (bytes[8] | bytes[9] << 8 | (bytes[9] & 0x80 ? 0xFF << 16 : 0));  
    sensor.accuracy  = (bytes[10] | bytes[11] << 8 | (bytes[9] & 0x80 ? 0xFF << 16 : 0)) / 100;
    sensor.battery   = (bytes[12] | bytes[13] << 8 | (bytes[9] & 0x80 ? 0xFF << 16 : 0)) / 1000;
    return( sensor );
}
```

## STEP 3.
Create a new 'http' Helium Integration.
  - The endpoint should be the location of where you are hosting the PHP script that will parse your devices data and send it to Tracarr.
  - You can use a simple webserver to host the PHP script. As long as its accessible on the internet it should work.
  - A Copy of the PHP script I used is in the files. tracarr.php



## OsmAnd Protocol
https://www.traccar.org/osmand/

## PHP Script
tracarr.php
