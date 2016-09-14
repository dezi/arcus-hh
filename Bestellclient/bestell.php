<?php header("Content-Type: text/plain"); ?>

bestell = {};

bestell.createFrame = function()
{
	document.body.style.margin = '0px';
	document.body.style.padding = '0px';
		
	bestell.createHeader();
	
	var contDiv = bestell.contDiv = document.createElement("div");
	contDiv.style.position = "relative";
	contDiv.style.padding = "20px";
	contDiv.style.backgroundColor = "#eeeeee";
	document.body.appendChild(contDiv);
	
	if (! bestell.context)
	{
		bestell.createLogin();
	}
	else
	{
	}
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

bestell.createLogin = function()
{
	bestell.contDiv.innerHTML = "";
	
	var centerDiv = document.createElement("center");
	centerDiv.style.padding = "20px";
	centerDiv.style.backgroundColor = "#eeffee";
	centerDiv.style.fontSize = "24px"; 
	bestell.contDiv.appendChild(centerDiv);
	
	var userDiv = document.createElement("div");
	userDiv.style.padding = "10px";
	centerDiv.appendChild(userDiv);
	
	var userText = document.createElement("span");
	userText.style.display = "inline-block"
	userText.style.paddingRight = "10px"
	userText.style.textAlign = "right"
	userText.style.width = "100px"
	userText.innerHTML = "Name:"
	userDiv.appendChild(userText);
	
	var userInput = document.createElement("input");
	userInput.style.fontSize = "24px"; 
	userInput.type = "text"; 
	userInput.size = 10; 
	userDiv.appendChild(userInput);
	
	var passDiv = document.createElement("div");
	passDiv.style.padding = "10px";
	centerDiv.appendChild(passDiv);
	
	var passText = document.createElement("span");
	passText.style.display = "inline-block"
	passText.style.paddingRight = "10px"
	passText.style.textAlign = "right"
	passText.style.width = "100px"
	passText.innerHTML = "Passwort:"
	passDiv.appendChild(passText);
	
	var passInput = document.createElement("input");
	passInput.style.fontSize = "24px"; 
	passInput.type = "password"; 
	passInput.size = 10; 
	passDiv.appendChild(passInput);
	
	var buttonDiv = document.createElement("div");
	buttonDiv.style.padding = "10px";
	centerDiv.appendChild(buttonDiv);
	
	var loginButton = document.createElement("input");
	loginButton.style.fontSize = "24px"; 
	loginButton.type = "button"; 
	loginButton.value = "Login"; 
	buttonDiv.appendChild(loginButton);
}

bestell.createFrame();