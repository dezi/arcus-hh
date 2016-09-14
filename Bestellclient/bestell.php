<?php header("Content-Type: text/plain"); ?>

bestell = {};

bestell.createFrame = function()
{
	document.body.style.margin = '0px';
	document.body.style.padding = '0px';
		
	bestell.createHeader();
}

bestell.createHeader = function()
{
	var headerDiv = document.createElement("div");
	
	headerDiv.style.position = "relative";
	headerDiv.style.height = "60px";
	headerDiv.style.padding = '20px';
	headerDiv.style.backgroundColor = "#ddddff";
	document.body.appendChild(headerDiv);
	
	var logoDiv = document.createElement("div");
	
	logoDiv.style.position = "absolute";
	logoDiv.style.left = "20px";
	logoDiv.style.top = "20px";
	logoDiv.style.bottom = "20px";
	headerDiv.appendChild(logoDiv);

	var logoImg = document.createElement("img");
	logoImg.src = "images/arcus_logo.jpg";
	logoImg.style.height = "100%";
	logoImg.style.width = "auto";
	logoDiv.appendChild(logoImg);
	
	var titleDiv = document.createElement("center");
	titleDiv.style.fontSize = "56px";
	titleDiv.innerHTML = "ARCUS - Bestellclient";
	headerDiv.appendChild(titleDiv);
}

bestell.createFrame();