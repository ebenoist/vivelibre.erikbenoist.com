/*
 * Slippery map implementation for Unión Cantinil using Polymaps
 * @Author: Erik Benoist
 *
 * This code can be used for anything at all. 
 */



//constArray for communityData in com.json JSON file
var commData; 

//Create Polymaps Instance 	
var po = org.polymaps;

//const Array for all community labels
var labels = {};

var map = po.map()
	.container(document.getElementById("map").appendChild(po.svg("svg")))
	.center({lat: 15.5858, lon: -91.7373})
	.zoomRange([1, 17])
	.zoom(13)
    .add(po.interact());
    

map.add(po.geoJson()
    .url('jsonsources/newcantinil.json')
    .id("cantinil"));
       

map.add(po.geoJson()
    .url('jsonsources/com.json')
    .id("comunidadesfill"));
       

map.add(po.geoJson()
    .url('jsonsources/newcentros.json')
    .on("load", add_labels)
    .id("centros"));
    
//Load another instance of the community layer that is invisible so that all clicks are on the community.  
map.add(po.geoJson()
    .url('jsonsources/com.json')
    .on("load", makeClickable)
    .id("comunidades"));

//Adds +/- widget 
map.add(po.compass().pan("none"));

/* 
 * Loops through all JSON elements and makes them clickable. 
 */    
function makeClickable(e) {
	commData = e;
	for (var i = 0; i < e.features.length; i++) {
		var feature = e.features[i];
		feature.element.setAttribute('onclick', 'set_footer("' + i + '");return false;');	  
		}
} 
  
/*
 * add_labels(e) loops through the elements in the JSON locates the corresponding element in the SVG DOM tree
 * and replaces the standard circle in the linked list with a text label corresponding to the name
 * of the community. 
 */  
function add_labels(e) {
  
	for (var i = 0; i < e.features.length; i++) {
  	   
		var f = e.features[i],
        	d = f.data,
        	oldElement = f.element,
        	parentElement = oldElement.parentNode,
        	newTextLabel = f.element = po.svg("text");
      		name = d.properties.Nombre;
      		communityType = d.properties.Clase;
      		
      		 parentElement.removeChild(oldElement);

      		
      		if ( communityType == 1) {

    		//set up new text label and get the parent's transform function to insure scaling. 
    		newTextLabel.setAttributeNS(null,"font-size","10px");
    		newTextLabel.setAttributeNS(null,"text-anchor","middle");
    		newTextLabel.setAttribute("transform", oldElement.childNodes[0].getAttribute("transform"));
			newTextLabel.setAttribute("class", "label");
	  
  			//Actual text label
    		var textNode = document.createTextNode(name);
    
    		newTextLabel.appendChild(textNode); //add Text to the label
    
   			//Remove the old element from the parent and attach the new child (label)
   			parentElement.appendChild(newTextLabel);
   			}
    }
}

//Find the element that is being clicked on shoot the data at the user.
function set_footer(i) {

	feature= commData.features[i];
	
	var properties = feature.data.properties;
	
	var agua = properties.AGUAENTUBA;
	var potable = properties.AGUAPOTABL;
	var noagua = properties.AGUANO;
	
	var latrine = properties.BANOLATRIN;
	var lavable = properties.BANOLAVABL;
	var airelibre = properties.BANOAIRE;
	
	var title = properties.NOMBRE;
    var codigo = properties.COMCODIGO;
	var pob = properties.POBLACION;
    var cat = properties.CATEGORIA;
    var hog = properties.HOGARES;
    var alumnos = properties.ALUMNOS;
    var elec	= properties.ELECTRICIA;
    var tiendas = properties.TIENDAS;
    var cantinas = properties.CANTINAS;
    var pres = properties.COCODE;
    var tel = properties.TEL;
    
    //numbers are in meters, change to something human readable
    var area = (Math.round((properties.Shape_Ar_1 / 1000000)*100)/100); //m^2 -> km^2
    var perim = (Math.round((properties.Shape_Le_1 / 1000)*100)/100); //m -> km
	
	//Format and spit html. 
	var ft = document.getElementById('infobox_text');
	var html = '<comtitle>' + cat + ' ' + title + '</comtitle>'+ 
				'<h1>General</h1>' +
				'<ul><li>Codigo: ' + codigo + 
				'</li><li>Tiendas: ' + tiendas +
				//'</li><li>Cantinas: ' + cantinas +
				'</li><li>Hogares: ' + hog +
				'</li><li>Alumnos: ' + alumnos +
				'</li><li>Electricidad: ' + elec + 
				'%</li><li>Población: ' + pob + '</li></ul>' +
				'<h1>Datos Geografícos</h1>' +
				'<ul><li>Area: ' + area + ' km<sup>2</sup>' +
				'</li><li>Perímetro: ' + perim + ' km<sup>2</sup></li></ul>' +
			    '<h1>Presidente de COCODE</h1>' +
			    '<ul><li>' + pres +
			    '</li><li>Tel: ' + tel + '</li></ul>';
	
	ft.innerHTML = html;
  
}





    
