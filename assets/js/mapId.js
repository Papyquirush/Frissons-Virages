window.initMap = function () {
    const mapElement = document.getElementById('map');

    if (!mapElement) {
        console.error('Element avec ID "map" introuvable.');
        return;
    }

    // Extract the 'name' parameter from the URL path
    const pathParts = window.location.pathname.split('/');
    const name = decodeURIComponent(pathParts[pathParts.length - 1]);
    console.log(name);

    if (!name) {
        console.error('Paramètre "name" introuvable dans l\'URL.');
        return;
    }

    fetch(`/api/parks/${name}`)
        .then(response => response.json())
        .then(park => {
            const map = new google.maps.Map(mapElement, {
                center: { lat: park.latitude, lng: park.longitude },
                zoom: 12,
            });

            const marker = new google.maps.Marker({
                position: { lat: park.latitude, lng: park.longitude },
                map: map,
                title: park.name,
            });

            const infoWindow = new google.maps.InfoWindow();

            marker.addListener('click', () => {
                fetch(`/api/parks/${park.name}/coasters`)
                    .then(response => response.json())
                    .then(coasters => {
                        const content = `
                            <h3><strong>${park.name}</strong></h3>
                            <ul>
                                ${coasters.map(coaster => `<li>${coaster.name}</li>`).join('')}
                            </ul>
                        `;
                        infoWindow.setContent(content);
                        infoWindow.open(map, marker);
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des coasters:', error);
                    });
            });
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des parcs:', error);
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