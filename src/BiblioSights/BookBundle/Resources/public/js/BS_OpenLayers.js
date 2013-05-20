var map;
var OSMlayer;
var markersLayer;
var addmarkerLayer;

function OpenLayers_init (book) {
    // Path to public img folder
    OpenLayers.ImgPath = "bundles/book/images/OLimg/";
    // Creando el mapa en el DIV "map"
    map = new OpenLayers.Map("map", {
        projection: new OpenLayers.Projection('ESPG:900913'),
        maxExtent: new OpenLayers.Bounds(-20037508, -20037508, 20037508, 20037508.34)
    });
    // Creando la capa base OSM
    OSMlayer = new OpenLayers.Layer.OSM("Base Layer");
    // Creando la capa vectorial que carga los datos vía geojson
    markersLayer = new OpenLayers.Layer.Vector("Markers", {
        strategies: [new OpenLayers.Strategy.Fixed()],
        protocol: new OpenLayers.Protocol.HTTP({
            url: "geojson/"+book,
            format: new OpenLayers.Format.GeoJSON()
        })
    });
    markersLayer.id = "JSON";
    // Creando la capa vectorial que permita añadir un punto
    addmarkerLayer = new OpenLayers.Layer.Vector("Added");
    // Añadiendo capacidad para dibujar puntos
    var drawPoint = new OpenLayers.Control.DrawFeature(addmarkerLayer, OpenLayers.Handler.Point, {
        featureAdded: getInfo
    });
    map.addControl(drawPoint);
    drawPoint.activate();
    // Añadiendo capas
    map.addLayer(OSMlayer);
    map.addLayer(markersLayer);
    map.addLayer(addmarkerLayer);
    // Registrando el evento "loadend" para evitar problemas al hacer zoom sobre los datos
    markersLayer.events.register("loadend", markersLayer, function () {
        map.zoomToExtent(map.getLayer("JSON").getDataExtent());
    });
    // Adding select feature control
    var select = new OpenLayers.Control.SelectFeature(markersLayer);
    map.addControl(select);
    select.activate();  
    // Select feature event
    markersLayer.events.on({
        featureselected: function(event) {
            var coords = new OpenLayers.LonLat(event.feature.geometry.x, event.feature.geometry.y);
            coords.transform(new OpenLayers.Projection("EPSG:900913"), new OpenLayers.Projection("EPSG:4326"));
            //event.feature.geometry.transform(new OpenLayers.Projection("EPSG:900913"), new OpenLayers.Projection("EPSG:4326"));
            $.ajax({            
                url: "http://nominatim.openstreetmap.org/reverse?format=json&lat="+coords.lat+"&lon="+coords.lon+"&zoom=18&addressdetails=1",
                success: function (data) {
                    var parsedData = $.parseJSON(data);
                    $.each(parsedData, function (index, value) {
                        var element = "";
                        var address;
                        $('#data').empty();
                        // Get address info
                        if (index === "address") {
                            address = value; 
                            $.each(address, function (index,value){
                                $('#data').append('<p><strong>'+index+':</strong> '+value+'</p>');                          
                            });
                        };                   
                    });
                }
            });           
        }
    });    
    // getInfo: 
    // a) Limit features added to one
    // b) Get feature addedd address to data div
    // c) Send marker data to the server
    function getInfo(event) {
        if (addmarkerLayer.features.length === 2) {
            addmarkerLayer.removeFeatures(addmarkerLayer.features[0]);
        };  
        event.geometry.transform(new OpenLayers.Projection("EPSG:900913"), new OpenLayers.Projection("EPSG:4326"));
        $.ajax({            
           url: "http://nominatim.openstreetmap.org/reverse?format=json&lat="+event.geometry.y+"&lon="+event.geometry.x+"&zoom=18&addressdetails=1",
           success: function (data) {
               var parsedData = $.parseJSON(data);
               event.geometry.transform(new OpenLayers.Projection("EPSG:4326"), new OpenLayers.Projection("EPSG:900913"));
               var lat = event.geometry.y;
               var lng = event.geometry.x;
               $("#data").empty().append('<p><strong>lat: </strong>'+lat+'</p><p><strong>lon: </strong>'+lng+'</p>');               
               $.each(parsedData, function (index, value) {
                   var element = "";
                   var address;
                   $('#data').empty();
                   // Get address info
                   if (index === "address") {
                      address = value; 
                      $.each(address, function (index,value){
                          $('#data').append('<p><strong>'+index+':</strong> '+value+'</p>');                          
                      });
                   };                   
               });
               $('#data').append('<a href="#" class="button round small" id="savefeature">Guardar punto</a>');
               $('#savefeature').click(function () {
                   var newMarker = {
                       bookid: book,
                       lat: lat,
                       lng: lng,
                       address: parsedData.address
                   };
                   $.post("../newmarker", JSON.stringify(newMarker), 'json');                   
               });
           }
        });
    };
}


