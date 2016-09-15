<?php header("Content-Type: text/plain"); ?>

bestell = {};

bestell.createFrame = function()
{
	document.body.style.margin = "0px";
	document.body.style.padding = "0px";
		
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
	
	bestell.unselect(headerDiv);
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
	logoImg.src = "images/arcus_logo.png";
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

bestell.unselect = function(elem)
{
	elem.style.setProperty( "-webkit-touch-callout", "none");
    elem.style.setProperty( "-webkit-user-select", "none");
    elem.style.setProperty( "-khtml-user-select", "none");
    elem.style.setProperty( "-moz-user-select", "none");
    elem.style.setProperty( "-ms-user-select", "none");
    elem.style.setProperty( "-user-select", "none");
}

bestell.createJobs = function()
{
	bestell.contDiv.innerHTML = null;
	
	var centerDiv = document.createElement("center");
	bestell.unselect(centerDiv);
	centerDiv.style.fontSize = "24px"; 
	centerDiv.style.lineHeight = "30px"; 
	centerDiv.style.height = "100%";
	bestell.contDiv.appendChild(centerDiv);

	var workDiv = document.createElement("div");
	workDiv.style.position = "relative"; 
	workDiv.style.width = "100%"; 
	workDiv.style.height = "100%"; 
	workDiv.style.border = "1px solid grey"; 
	centerDiv.appendChild(workDiv);

	var jobsLeg = document.createElement("div");
	jobsLeg.style.position = "absolute"; 
	jobsLeg.style.top = "0px"; 
	jobsLeg.style.left = "0%"; 
	jobsLeg.style.width = "30%"; 
	jobsLeg.style.bottom = "0px"; 
	jobsLeg.style.backgroundColor = "#ffffee";
	workDiv.appendChild(jobsLeg);
	
	var jobsTitle = document.createElement("center");
	jobsTitle.style.padding = "10px";
	jobsTitle.style.position = "absolute";
	jobsTitle.style.top = "0px";
	jobsTitle.style.left = "0px";
	jobsTitle.style.right = "30px";
	jobsTitle.style.height = "29px";
	jobsTitle.style.borderBottom = "1px solid grey";
	jobsTitle.style.backgroundColor = "#bbbbbb";
	jobsTitle.innerHTML = "Aufträge";
	jobsLeg.appendChild(jobsTitle);

	var jobsNew = document.createElement("div");
	jobsNew.style.padding = "10px";
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
	jobsContent.style.top = "50px";
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
	itemsLeg.style.left = "30%"; 
	itemsLeg.style.width = "70%"; 
	itemsLeg.style.bottom = "0px"; 
	itemsLeg.style.backgroundColor = "#ffeeff";
	workDiv.appendChild(itemsLeg);
	
	var itemsTitle = document.createElement("center");
	itemsTitle.style.padding = "10px";
	itemsTitle.style.position = "absolute";
	itemsTitle.style.top = "0px";
	itemsTitle.style.left = "0px";
	itemsTitle.style.right = "30px";
	itemsTitle.style.height = "29px";
	itemsTitle.style.borderBottom = "1px solid grey";
	itemsTitle.style.backgroundColor = "#bbbbbb";
	itemsTitle.innerHTML = "Artikel";
	itemsLeg.appendChild(itemsTitle);

	var itemsNew = document.createElement("div");
	itemsNew.style.padding = "10px";
	itemsNew.style.position = "absolute";
	itemsNew.style.top = "0px";
	itemsNew.style.right = "0px";
	itemsNew.style.height = "30px";
	itemsNew.style.backgroundColor = "#888888";
	itemsNew.innerHTML = "+";
	itemsNew.onclick = bestell.addItem;
	itemsLeg.appendChild(itemsNew);

	var itemsContent = document.createElement("div");
	itemsContent.style.overflowX = "hidden";
	itemsContent.style.overflowY = "auto";
	itemsContent.style.position = "absolute";
	itemsContent.style.left = "0px";
	itemsContent.style.top = "50px";
	itemsContent.style.right = "0px";
	itemsContent.style.bottom = "0px";
	itemsContent.style.backgroundColor = "#ffffff";
	itemsLeg.appendChild(itemsContent);
	
	bestell.itemsContent = itemsContent;
}

bestell.addItem = function()
{
	if (! bestell.hasOwnProperty("selectedJob")) return;

	var job = bestell.context.jobs[ bestell.selectedJob ];
	if (! job.hasOwnProperty("items")) job.items = [];
	
	var item = {};
	
	item.guid = new Date().getTime();
	
	job.items.unshift(item);
	bestell.selectedItem = 0;

	bestell.updateItems();
}

bestell.addJob = function()
{
	var job = {};
	
	job.date = new Date().getTime() / 1000;
	job.name = bestell.fullDateString(job.date);
	job.send = false;
	job.items = [];

	bestell.context.jobs.unshift(job);
	bestell.selectedJob = 0;
	bestell.selectedItem = 0;
	
	bestell.updateJobs();
}

bestell.selectItem = function(event)
{
	if (! bestell.hasOwnProperty("selectedJob")) return;
	var job = bestell.context.jobs[ bestell.selectedJob ];

	var target = event.target;
	
	if (target.nodeName == "INPUT") return;
	if (target.nodeName == "SELECT") return;
	if (target.nodeName == "OPTION") return;
	
	console.log("bestell.selectItem: " + event.target.nodeName);
	
	while (target && ! target.hasOwnProperty("itemIndex"))
	{
		target = target.parentNode;
	}
	
	if (! target) return;

	bestell.selectedItem = target.itemIndex;
	
	bestell.updateItems();
}


bestell.selectJob = function(event)
{
	var target = event.target;
	
	while (target && ! target.hasOwnProperty("jobIndex"))
	{
		target = target.parentNode;
	}
	
	if (! target) return;

	bestell.selectedJob = target.jobIndex;
	bestell.updateJobs();
}

bestell.removeItem = function(event)
{
	if (! bestell.hasOwnProperty("selectedJob")) return;
	var job = bestell.context.jobs[ bestell.selectedJob ];

	var itemIndex = event.target.itemIndex;
	var item = job.items[ itemIndex ];
	
	if (confirm("Wollen Sie diesen Artikel löschen? => " + item.title))
	{
		job.items.splice(itemIndex, 1);
		bestell.updateItems();
	}
}

bestell.removeJob = function(event)
{
	var jobIndex = event.target.jobIndex;
	var job = bestell.context.jobs[ jobIndex ];
	
	if (confirm("Wollen Sie diesen Job löschen? => " + job.name))
	{
		bestell.context.jobs.splice(jobIndex, 1);
		bestell.updateJobs();
	}
}

bestell.createSachSelect = function(inputSize)
{
	var sachInput = document.createElement("select");
	sachInput.style.width = "30%";
	sachInput.style.height = "90%";
	sachInput.style.border = "0px";
	sachInput.style.margin = "0px";
	sachInput.style.marginRight = "4px";
	sachInput.style.padding = "0px";
	sachInput.style.fontSize = inputSize;
	
	var sach = bestell.context.sach;
	
	for (var fnz = 0; fnz < sach.length; fnz++)
	{
		var option = document.createElement("option");
		option.value = sach[ fnz ];
		option.text  = sach[ fnz ];
		sachInput.add(option);
	}

	return sachInput;
}

bestell.updateItems = function()
{
	var itemsContent = bestell.itemsContent;
	itemsContent.innerHTML = null;

	if (! bestell.hasOwnProperty("selectedJob")) return;
	var job = bestell.context.jobs[ bestell.selectedJob ];
	if (! job.hasOwnProperty("items")) job.items = [];
	
	var fontSize = "18px";
	var inputSize = "16px";
	
	for (var inx = 0; inx < job.items.length; inx++)
	{
		var item = job.items[ inx ];
		
		var selected = (bestell.selectedItem == inx);
		
		var itemDiv = document.createElement("div");
		itemDiv.style.position = "relative";
		itemDiv.style.height = "50px";
		itemDiv.style.fontSize = fontSize;
		itemDiv.style.lineHeight = "28px";
		itemDiv.style.borderBottom = "1px solid grey";

		if (selected)
		{
			itemDiv.style.backgroundColor = item.ok ? "#bbffbb" : "#ffbbbb";
		}
		else
		{
			itemDiv.style.backgroundColor = item.ok ? "#eeffee" : "#ffeeee";
		}

		itemDiv.style.fontSize = fontSize;
		itemDiv.style.textAlign = "left";
		itemDiv.onclick = bestell.selectItem;
		itemDiv.itemIndex = inx;
		itemsContent.appendChild(itemDiv);
		
		var itemLine1 = document.createElement("div");
		itemLine1.style.position = "absolute";
		itemLine1.style.top = "0px";
		itemLine1.style.left = "0px";
		itemLine1.style.right = "0px";
		itemLine1.style.bottom = "25px";
		itemDiv.appendChild(itemLine1);

		var itemLine2 = document.createElement("div");
		itemLine2.style.position = "absolute";
		itemLine2.style.top = "25px";
		itemLine2.style.left = "0px";
		itemLine2.style.right = "0px";
		itemLine2.style.bottom = "0px";
		itemDiv.appendChild(itemLine2);

		var sourceDiv = document.createElement("div");
		sourceDiv.style.position = "absolute";
		sourceDiv.style.top = "0%";
		sourceDiv.style.left = "2%";
		sourceDiv.style.bottom = "0%";
		sourceDiv.style.right = "72%";
		itemLine1.appendChild(sourceDiv);
		
		if (selected)
		{
			var sourceInput = document.createElement("select");
			sourceInput.style.width = "100%";
			sourceInput.style.height = "90%";
			sourceInput.style.border = "0px";
			sourceInput.style.margin = "0px";
			sourceInput.style.padding = "0px";
			sourceInput.style.fontSize = inputSize;
			
			var sources = bestell.context.sources;
			
			for (var prop in sources)
			{
				var option = document.createElement("option");
				option.value = prop;
				option.text  = prop + " - " + sources[ prop ];
				sourceInput.add(option);
			}
			        
			sourceDiv.appendChild(sourceInput);
		}
		else
		{
			sourceDiv.innerHTML = "ND2";
		}
		
		var dateDiv = document.createElement("div");
		dateDiv.style.position = "absolute";
		dateDiv.style.top = "0%";
		dateDiv.style.left = "30%";
		dateDiv.style.bottom = "0%";
		dateDiv.style.right = "52%";
		itemLine1.appendChild(dateDiv);
		
		if (selected)
		{
			var dateInput = document.createElement("input");
			dateInput.style.width = "100%";
			dateInput.style.height = "90%";
			dateInput.style.border = "0px";
			dateInput.style.margin = "0px";
			dateInput.style.padding = "0px";
			dateInput.style.fontSize = inputSize;
			dateInput.type = "text";
			dateInput.value = "29.05.1962";
			
			dateDiv.appendChild(dateInput);
		}
		else
		{
			dateDiv.innerHTML = "29.05.1962";
		}
		
		var pageDiv = document.createElement("div");
		pageDiv.style.position = "absolute";
		pageDiv.style.top = "0%";
		pageDiv.style.left = "50%";
		pageDiv.style.bottom = "0%";
		pageDiv.style.right = "42%";
		itemLine1.appendChild(pageDiv);
		
		if (selected)
		{
			var pageInput = document.createElement("input");
			pageInput.style.width = "100%";
			pageInput.style.height = "90%";
			pageInput.style.border = "0px";
			pageInput.style.margin = "0px";
			pageInput.style.padding = "0px";
			pageInput.style.fontSize = inputSize;
			pageInput.type = "text";
			pageInput.value = "322";
			
			pageDiv.appendChild(pageInput);
		}
		else
		{
			pageDiv.innerHTML = "322";
		}
		
		var sachDiv = document.createElement("div");
		sachDiv.style.position = "absolute";
		sachDiv.style.top = "0%";
		sachDiv.style.left = "60%";
		sachDiv.style.bottom = "0%";
		sachDiv.style.right = "28px";
		itemLine1.appendChild(sachDiv);
		
		if (selected)
		{
			sachDiv.appendChild(bestell.createSachSelect(inputSize));
			sachDiv.appendChild(bestell.createSachSelect(inputSize));
			sachDiv.appendChild(bestell.createSachSelect(inputSize));
		}
		else
		{
			sachDiv.innerHTML = "AAA, B, PLT";
		}
		
		var titleDiv = document.createElement("div");
		titleDiv.style.position = "absolute";
		titleDiv.style.top = "0%";
		titleDiv.style.left = "2%";
		titleDiv.style.bottom = "0%";
		titleDiv.style.right = "28px";
		itemLine2.appendChild(titleDiv);
		
		if (selected)
		{
			var titleInput = document.createElement("input");
			titleInput.style.width = "100%";
			titleInput.style.height = "90%";
			titleInput.style.border = "0px";
			titleInput.style.margin = "0px";
			titleInput.style.padding = "0px";
			titleInput.style.fontSize = inputSize;
			titleInput.type = "text";
			titleInput.value = "Bibliothek wackelt";
			
			titleDiv.appendChild(titleInput);
		}
		else
		{
			titleDiv.innerHTML = "Bibliothek wackelt";
		}
		

		
		var itemIcon = document.createElement("img");
		itemIcon.style.position = "absolute";
		itemIcon.style.top = "15px";
		itemIcon.style.right = "5px";
		itemIcon.style.width = "20px";
		itemIcon.style.height = "20px";
		itemIcon.src = "images/remove.png";
		itemIcon.onclick = bestell.removeItem;
		itemIcon.itemIndex = inx;
		itemDiv.appendChild(itemIcon);
	}
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
		
		if (bestell.selectedJob == inx)
		{
			jobDiv.style.backgroundColor = job.send ? "#bbffbb" : "#ffbbbb";
		}
		else
		{
			jobDiv.style.backgroundColor = job.send ? "#eeffee" : "#ffeeee";
		}

		jobDiv.onclick = bestell.selectJob;
		jobDiv.jobIndex = inx;
		jobsContent.appendChild(jobDiv);
		
		var jobDate = document.createElement("center");
		jobDate.style.lineHeight = "60px";
		jobDate.innerHTML = bestell.fullDateHuman(job.date)
		jobDiv.appendChild(jobDate);
		
		var jobIcon = document.createElement("img");
		jobIcon.style.position = "absolute";
		jobIcon.style.top = "15px";
		jobIcon.style.right = "5px";
		jobIcon.style.width = "20px";
		jobIcon.style.height = "20px";
		jobIcon.src = "images/remove.png";
		jobIcon.onclick = bestell.removeJob;
		jobIcon.jobIndex = inx;
		jobDiv.appendChild(jobIcon);
	}
	
	bestell.updateItems();
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











