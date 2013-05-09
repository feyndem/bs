var map;
var OSMlayer;
var markersLayer;

function OpenLayers_init () {
    // Path to public img folder
    OpenLayers.ImgPath = "bundles/openlayers/images/OLimg/";
    // Creando el mapa en el DIV "map"
    map = new OpenLayers.Map("map", {
        projection: new OpenLayers.Projection('ESPG:900913'),
        maxExtent: new OpenLayers.Bounds(-20037508, -20037508, 20037508, 20037508.34)
    });
    // Creando la capa base OSM
    OSMlayer = new OpenLayers.Layer.OSM("Base Layer");
    // Creando la capa vectorial que permita añadir un punto
    addmarkerLayer = new OpenLayers.Layer.Vector("Added");
    // Añadiendo capas
    map.addLayer(OSMlayer);
    map.addLayer(addmarkerLayer);
    map.zoomToMaxExtent();
}


