let addressName = null;
let lat;
let lng;
let countryCode;
let capitalCity;
let gpsData;
let weatherData;
let ip;

let isError = false;

let addressButton = document.getElementById('address-button')
addressButton.addEventListener('click', async () => {
    addressName = document.getElementById('address').value;

    await getLatLngCountry(addressName)

    await getWeather()

    await getCapital(countryCode)

    await getIP()

    if (isError === true){
        toastr.error("Zadané pole nie je vyplnené alebo nastala nejaká chyba, skúste znovu.")
        return
    }

    let jsonGps = JSON.stringify(gpsData)
    let jsonWeather = JSON.stringify(weatherData);
    let thisDateTime = new Date().toLocaleString();

    document.cookie = "gps="+jsonGps+";"
    document.cookie = "capital="+capitalCity+";"
    document.cookie = "countryCode="+countryCode+";"
    document.cookie = "weather="+jsonWeather+";"
    document.cookie = "ip="+ip+";"
    document.cookie = "dateTime="+thisDateTime+";"

    //await toastr.success('Pridanie adresy prebehlo úspešne!')

    window.location.href = "https://site87.webte.fei.stuba.sk/zadanie4rt41/description.php"

})


async function getLatLngCountry(addressName){
    await fetch(`https://maps.googleapis.com/maps/api/geocode/json?address=${addressName}&key=AIzaSyBPxCp1fTlpVPHqv0Cwce4R7r8pbn0LUz8&sensor=false`)
        .then(response => response.json())
        .then(data => {
            // do something with the JSON data here
            console.log(data);
            lat = data.results[0].geometry.location.lat
            lng = data.results[0].geometry.location.lng

            gpsData = data;
        })
        .catch(error => {
            console.error('Error fetching JSON data:', error);
            isError = true;
        });
}

async function getCapital(countryCode){
    await fetch(`https://restcountries.com/v3.1/alpha/${countryCode}`)
        .then(async response => await response.json())
        .then(data => {
            capitalCity = data[0].capital;
        })
        .catch(error => {
            isError = true;
            console.error(`Error occurred while getting capital city of ${countryCode}: ${error}`);
        });
}


let tempDescSpan = document.getElementById('temp-desc')
async function getWeather(){
    await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lng}&appid=8c9a14c1ffac6419c8087104b45b8fdb`)
        .then(response => response.json())
        .then(data => {
            // do something with the JSON data here
            console.log(data);
            tempDescSpan = data.weather[0].description
            weatherData = data;
            countryCode = data.sys.country;

        })
        .catch(error => {
            isError = true;
            console.error("Error fetching JSON data:", error);
        });
}

async function getIP(){
    await fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            ip = data.ip;
            console.log(ip)
        })
        .catch(error => {
            console.error(error)
            isError = true;
        });
}