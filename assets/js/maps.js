window.initMap = function () {
    const defaultLocation = { lat: 48.8566, lng: 2.3522 };

    const mapElement = document.getElementById('map');

    if (!mapElement) {
        console.error('Element avec ID "map" introuvable.');
        return;
    }

    const map = new google.maps.Map(mapElement, {
        center: defaultLocation,
        zoom: 12,
    });

    new google.maps.Marker({
        position: defaultLocation,
        map: map,
        title: 'Hello Paris!',
    });
};

function loadGoogleMaps(apiKey) {
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`;
    script.async = true;
    script.defer = true;

    script.onerror = () => {
        console.error("Le script Google Maps n'a pas pu être chargé.");
    };

    document.head.appendChild(script);
}

document.addEventListener('DOMContentLoaded', () => {
    const apiKey = 'AIzaSyA6xWzQTYP8XGCjw2n9k6JHCRb7UtcZoNY';
    loadGoogleMaps(apiKey);
});
