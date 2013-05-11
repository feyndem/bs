var map;
var OSMlayer;

function OpenLayers_init () {
    // Path to public img folder
    OpenLayers.ImgPath = "bundles/openlayers/images/OLimg/";
    // Creando el mapa en el DIV "map"
    map = new OpenLayers.Map("map");
    // Creando la capa base OSM
    OSMlayer = new OpenLayers.Layer.OSM("Base Layer");
    // Creando la capa vectorial que permita añadir un punto
    var addmarkerLayer = new OpenLayers.Layer.Vector("Added");
    // Añadiendo capas
    map.addLayer(OSMlayer);
    map.addLayer(addmarkerLayer);
    map.zoomToMaxExtent();
}


