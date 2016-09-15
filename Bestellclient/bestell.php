<?php header("Content-Type: text/plain"); ?>

bestell = {};

bestell.createFrame = function()
{
	document.body.style.margin = '0px';
	document.body.style.padding = '0px';
		
	bestell.createHeader();
	
	var contDiv = document.createElement("div");
	contDiv.style.position = "relative";
	contDiv.style.padding = "20px";
	contDiv.style.backgroundColor = "#eeeeee";
	document.body.appendChild(contDiv);
	
	bestell.contDiv = contDiv;
	
	bestell.loadContext();
	
	if (! bestell.context)
	{
		bestell.createLogin();
	}
	else
	{
		bestell.displayLogin();
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
	
	var userDiv = document.createElement("div");
	
	userDiv.style.position = "absolute";
	userDiv.style.right = "20px";
	userDiv.style.top = "20px";
	userDiv.style.bottom = "20px";
	userDiv.style.textAlign = "right";
	userDiv.style.lineHeight = "24px";
	headerDiv.appendChild(userDiv);
	
	bestell.userDiv = userDiv;
}

bestell.createLogin = function()
{
	bestell.userDiv.innerHTML = null;
	bestell.contDiv.innerHTML = null;
	
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
	userInput.name = "user"; 
	userInput.value = "ZDF_Mainz"; 
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
	passInput.name = "password"; 
	passInput.value = "keins"; 
	passInput.size = 10; 
	passDiv.appendChild(passInput);
	
	var buttonDiv = document.createElement("div");
	buttonDiv.style.padding = "10px";
	centerDiv.appendChild(buttonDiv);
	
	var loginButton = document.createElement("input");
	loginButton.style.fontSize = "24px"; 
	loginButton.style.width = "280px"; 
	loginButton.type = "button"; 
	loginButton.value = "Login";
	loginButton.onclick = bestell.loginClick;
	buttonDiv.appendChild(loginButton);
	
	bestell.userInput = userInput;
	bestell.passInput = passInput;
}

bestell.zeroPadStringLeft = function(str, digits)
{
	str += "";
	
	while (str.length < digits)
	{
		str = "0" + str;
	}
	
	return str;
}

bestell.fullDateHuman = function(timestamp)
{
	var date = new Date(timestamp * 1000);
	
	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();
	var hour = date.getHours();
	var minute = date.getMinutes();
	
	var dst = bestell.zeroPadStringLeft(day, 2)
			+ "."
			+ bestell.zeroPadStringLeft(month, 2)
			+ "."
			+ bestell.zeroPadStringLeft(year, 4)
			+ " "
			+ bestell.zeroPadStringLeft(hour, 2)
			+ ":"
			+ bestell.zeroPadStringLeft(minute, 2)
			;
		
	return dst;
}

bestell.displayLogin = function()
{
	var userDiv = bestell.userDiv;
	userDiv.innerHTML = null;
	
	var userText = document.createElement("div");
	userText.innerHTML = bestell.context.user;
	
	userDiv.appendChild(userText);
	
	var dateText = document.createElement("div");
	dateText.innerHTML = bestell.fullDateHuman(bestell.context.time);
	
	userDiv.appendChild(dateText);
	
	var logoutButton = document.createElement("input");
	logoutButton.style.fontSize = "12px"; 
	logoutButton.style.width = "100px"; 
	logoutButton.type = "button"; 
	logoutButton.value = "Logout";
	logoutButton.onclick = bestell.logoutClick;
	userDiv.appendChild(logoutButton);
}

bestell.loginClick = function()
{
	var url = "login.php";
	
	url += "?user=" + encodeURIComponent(bestell.userInput.value);
	url += "&pass=" + encodeURIComponent(bestell.passInput.value);
	
	bestell.requestJavascript(url);
}

bestell.logoutClick = function()
{
	localStorage.removeItem("context");
	bestell.context = null;
	
	bestell.createLogin();
}

bestell.loginCallback = function(data)
{
	if (! data)
	{
		alert("Login falsch...");
		
		return;
	}
	
	bestell.context = data;
	
	console.log(data);
	
	bestell.displayLogin();
	bestell.saveContext();
}

bestell.requestJavascript = function(url)
{
    var head = document.getElementsByTagName("head")[0]
    
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = url;

    head.insertBefore(script, head.firstChild);
    head.removeChild(script);
}

bestell.saveContext = function()
{
	localStorage.setItem("context", JSON.stringify(bestell.context));
}

bestell.loadContext = function()
{
	var json = localStorage.getItem("context");
	bestell.context = json ? JSON.parse(json) : null;
}

bestell.createFrame();











