import { MarkerClusterer } from '@googlemaps/markerclusterer';

window.initMap = function () {
    const defaultLocation = { lat: 48.8566, lng: 2.3522 };

    const mapElement = document.getElementById('map');

    if (!mapElement) {
        console.error('Element avec ID "map" introuvable.');
        return;
    }

    const map = new google.maps.Map(mapElement, {
        center: defaultLocation,
        zoom: 6,
    });

    fetch('/api/parks')
        .then(response => response.json())
        .then(parks => {
            const markers = parks.map(park => {
                const marker = new google.maps.Marker({
                    position: { lat: park.latitude, lng: park.longitude },
                    title: park.name,
                });

                const infoWindow = new google.maps.InfoWindow();

                marker.addListener('click', () => {
                    fetch(`/api/parks/${park.name}/coasters`)
                        .then(response => response.json())
                        .then(coasters => {
                            const content = `
                                <h3 class="font-bold text-lg">${park.name}</h3>
                                <ul class="list-disc pl-5">
                                    ${coasters.map(coaster => `
                                        <li class="flex items-center">
                                            ${coaster.name}
                                            <span class="ml-2 inline-block w-3 h-3 rounded-full ${
                                coaster.status.name === 'status.operating' ? 'bg-green-500' :
                                    coaster.status.name === 'status.closed.definitely' ? 'bg-red-500' : 'bg-orange-500'
                            }"></span>
                                        </li>
                                    `).join('')}
                                </ul>
                            `;
                            infoWindow.setContent(content);
                            infoWindow.open(map, marker);
                        })
                        .catch(error => {
                            console.error('Erreur lors de la récupération des coasters:', error);
                        });
                });

                return marker;
            });

            // Utiliser MarkerClusterer pour gérer les clusters de marqueurs
            new MarkerClusterer({ map, markers });
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