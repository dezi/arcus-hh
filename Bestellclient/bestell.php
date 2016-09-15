<?php header("Content-Type: text/plain"); ?>

bestell = {};

bestell.createFrame = function()
{
	document.body.style.margin = '0px';
	document.body.style.padding = '0px';
		
	bestell.createHeader();
	
	var contDiv = document.createElement("div");
	contDiv.style.position = "absolute";
	contDiv.style.top = "100px";
	contDiv.style.left = "0px";
	contDiv.style.right = "0px";
	contDiv.style.bottom = "0px";
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
		bestell.createJobs();
	}
}

bestell.createHeader = function()
{
	var headerDiv = document.createElement("div");
	
	headerDiv.style.position = "absolute";
	headerDiv.style.top = "0px";
	headerDiv.style.left = "0px";
	headerDiv.style.right = "0px";
	headerDiv.style.height = "60px";
	headerDiv.style.padding = "20px";
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

bestell.createJobs = function()
{
	bestell.contDiv.innerHTML = null;
	
	var centerDiv = document.createElement("center");
	centerDiv.style.fontSize = "24px"; 
	centerDiv.style.height = "100%"; 
	bestell.contDiv.appendChild(centerDiv);

	var workDiv = document.createElement("div");
	workDiv.style.position = "relative"; 
	workDiv.style.width = "800px"; 
	workDiv.style.height = "100%"; 
	workDiv.style.border = "1px solid grey"; 
	centerDiv.appendChild(workDiv);

	var jobsLeg = document.createElement("div");
	jobsLeg.style.position = "absolute"; 
	jobsLeg.style.top = "0px"; 
	jobsLeg.style.left = "0%"; 
	jobsLeg.style.width = "50%"; 
	jobsLeg.style.bottom = "0px"; 
	jobsLeg.style.backgroundColor = "#ffffee";
	workDiv.appendChild(jobsLeg);
	
	var jobsTitle = document.createElement("center");
	jobsTitle.style.padding = "15px";
	jobsTitle.style.position = "absolute";
	jobsTitle.style.top = "0px";
	jobsTitle.style.left = "0px";
	jobsTitle.style.right = "0px";
	jobsTitle.style.height = "29px";
	jobsTitle.style.borderBottom = "1px solid grey";
	jobsTitle.style.backgroundColor = "#bbbbbb";
	jobsTitle.innerHTML = "Aufträge";
	jobsLeg.appendChild(jobsTitle);
	
	var jobsNew = document.createElement("div");
	jobsNew.style.padding = "15px";
	jobsNew.style.position = "absolute";
	jobsNew.style.top = "0px";
	jobsNew.style.right = "0px";
	jobsNew.style.height = "30px";
	jobsNew.style.backgroundColor = "#888888";
	jobsNew.innerHTML = "+";
	jobsNew.onclick = bestell.addJob;
	jobsLeg.appendChild(jobsNew);

	var jobsContent = document.createElement("div");
	jobsContent.style.overflowX = "hidden";
	jobsContent.style.overflowY = "auto";
	jobsContent.style.position = "absolute";
	jobsContent.style.left = "0px";
	jobsContent.style.top = "60px";
	jobsContent.style.right = "0px";
	jobsContent.style.bottom = "0px";
	jobsContent.style.backgroundColor = "#ffffff";
	jobsLeg.appendChild(jobsContent);
	
	bestell.jobsContent = jobsContent;
	
	var itemsLeg = document.createElement("div");
	itemsLeg.style.borderLeft = "1px solid grey";
	itemsLeg.style.borderRight = "1px solid grey";
	itemsLeg.style.position = "absolute"; 
	itemsLeg.style.top = "0px"; 
	itemsLeg.style.left = "50%"; 
	itemsLeg.style.width = "50%"; 
	itemsLeg.style.bottom = "0px"; 
	itemsLeg.style.backgroundColor = "#ffeeff";
	workDiv.appendChild(itemsLeg);
	
	var itemsTitle = document.createElement("center");
	itemsTitle.style.padding = "15px";
	itemsTitle.style.position = "absolute";
	itemsTitle.style.top = "0px";
	itemsTitle.style.left = "0px";
	itemsTitle.style.right = "0px";
	itemsTitle.style.height = "29px";
	itemsTitle.style.borderBottom = "1px solid grey";
	itemsTitle.style.backgroundColor = "#bbbbbb";
	itemsTitle.innerHTML = "Artikel";
	itemsLeg.appendChild(itemsTitle);

	var itemsNew = document.createElement("div");
	itemsNew.style.padding = "15px";
	itemsNew.style.position = "absolute";
	itemsNew.style.top = "0px";
	itemsNew.style.right = "0px";
	itemsNew.style.height = "30px";
	itemsNew.style.backgroundColor = "#888888";
	itemsNew.innerHTML = "+";
	itemsNew.onclick = bestell.addItem;
	itemsLeg.appendChild(itemsNew);
}

bestell.addItem = function()
{
}

bestell.addJob = function()
{
	var job = {};
	
	job.date = new Date().getTime() / 1000;
	job.name = bestell.fullDateString(job.date);
	job.send = false;

	bestell.context.jobs.unshift(job);
	
	bestell.updateJobs();
}

bestell.updateJobs = function()
{
	var jobsContent = bestell.jobsContent;

	jobsContent.innerHTML = null;
	
	var jobs = bestell.context.jobs;
	
	for (var inx = 0; inx < jobs.length; inx++)
	{
		var job = jobs[ inx ];
		
		var jobDiv = document.createElement("div");
		jobDiv.style.position = "relative";
		jobDiv.style.height = "50px";
		jobDiv.style.borderBottom = "1px solid grey";
		jobDiv.style.backgroundColor = job.send ? "#ddffdd" : "#ffdddd";
		jobsContent.appendChild(jobDiv);
		
		var jobDate = document.createElement("center");
		jobDiv.style.lineHeight = "50px";
		jobDate.innerHTML = bestell.fullDateHuman(job.date)
		jobDiv.appendChild(jobDate);
	}
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

bestell.fullDateString = function(timestamp)
{
	var date = new Date(timestamp * 1000);
	
	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();
	var hour = date.getHours();
	var minute = date.getMinutes();
	
	var dst = bestell.zeroPadStringLeft(year, 4)
			+ "_"
			+ bestell.zeroPadStringLeft(month, 2)
			+ "_"
			+ bestell.zeroPadStringLeft(day, 4)
			+ "_"
			+ bestell.zeroPadStringLeft(hour, 2)
			+ "_"
			+ bestell.zeroPadStringLeft(minute, 2)
			;
		
	return dst;
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
	bestell.saveContext();

	console.log(data);
	
	bestell.displayLogin();
	bestell.createJobs();
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











