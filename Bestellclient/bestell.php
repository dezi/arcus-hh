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
		if (bestell.context.jobs && (bestell.context.jobs.length > 0))
		{
			bestell.selectedJob = 0;
		}
		
		bestell.displayLogin();
		bestell.createJobs();
		bestell.updateJobs();
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
	itemsTitle.style.right = "0px";
	itemsTitle.style.height = "29px";
	itemsTitle.style.borderBottom = "1px solid grey";
	itemsTitle.style.backgroundColor = "#bbbbbb";
	itemsTitle.innerHTML = "Artikel";
	itemsLeg.appendChild(itemsTitle);

	var itemsNew = document.createElement("div");
	itemsNew.style.display = "none";
	itemsNew.style.padding = "10px";
	itemsNew.style.position = "absolute";
	itemsNew.style.top = "0px";
	itemsNew.style.right = "0px";
	itemsNew.style.height = "30px";
	itemsNew.style.backgroundColor = "#888888";
	itemsNew.innerHTML = "+";
	itemsNew.onclick = bestell.addItem;
	itemsLeg.appendChild(itemsNew);
	
	bestell.itemsNew = itemsNew;

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
	
	item.guid = "" + new Date().getTime();
	item.source = "";
	item.date = "";
	item.page = "";
	item.sach = "";
	item.title = "";
	item.notes = "";

	if (job.items.length > 0)
	{
		item.source = job.items[ 0 ].source;
		item.date = job.items[ 0 ].date;
		item.page = job.items[ 0 ].page;
	}
	
	job.items.unshift(item);
	bestell.selectedItem = 0;

	bestell.updateItems();
	bestell.saveContext();
	
	bestell.updateRemoteItem("u", job, item);
}

bestell.addJob = function()
{
	var job = {};
	
	job.date = Math.floor(new Date().getTime() / 1000);
	job.name = bestell.fullDateString(job.date);
	job.items = [];

	for (var inx = 0; inx < bestell.context.jobs.length; inx++)
	{
		if (bestell.context.jobs[ inx ].name == job.name)
		{
			alert("Dieser Job ist schon vorhanden.\n\n"
					+ "Bitte warte Sie eine Minute, "
					+ "bevor Sie einen weiteren Job anlegen");
					
			return;
		}
	}
	
	bestell.context.jobs.unshift(job);
	bestell.selectedJob = 0;
	bestell.selectedItem = -1;
	
	bestell.updateJobs();
	bestell.saveContext();
	
	bestell.updateRemoteJob("u", job);
}

bestell.updateRemoteJob = function(mode, job)
{
	var url = "update.php";
	
	url += "?user=" + bestell.context.user;
	url += "&mode=" + mode;
	url += "&jobname=" + job.name;
	url += "&jobdate=" + job.date;

	if (job.send) url += "&jobsend=" + job.send;
	
	bestell.requestJavascript(url);
}

bestell.sendftpRemoteJob = function(job)
{
	var url = "sendftp.php";
	
	url += "?user=" + bestell.context.user;
	url += "&jobname=" + job.name;
	
	bestell.requestJavascript(url);
}

bestell.updateRemoteItem = function(mode, job, item)
{
	var url = "update.php";
	
	url += "?user=" + bestell.context.user;
	url += "&mode=" + mode;
	url += "&jobname=" + job.name;

	url += "&guid=" + item.guid;
	url += "&source=" + item.source;
	url += "&date=" + item.date;
	url += "&page=" + item.page;
	url += "&sach=" + item.sach;
	url += "&title=" + item.title;
	url += "&notes=" + item.notes;
	url += "&ok=" + item.ok;

	bestell.requestJavascript(url);
}

bestell.selectItem = function(event)
{
	if (! bestell.hasOwnProperty("selectedJob")) return;
	var job = bestell.context.jobs[ bestell.selectedJob ];

	var target = event.target;
	
	if (target.nodeName == "IMG") return;
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
	
	if (target.nodeName == "IMG") return;

	while (target && ! target.hasOwnProperty("jobIndex"))
	{
		target = target.parentNode;
	}
	
	if (! target) return;

	bestell.selectedJob = target.jobIndex;
	bestell.selectedItem = -1;
	
	bestell.updateJobs();
}

bestell.removeItem = function(event)
{
	event.preventDefault();

	if (! bestell.hasOwnProperty("selectedJob")) return;
	var job = bestell.context.jobs[ bestell.selectedJob ];

	var itemIndex = event.target.itemIndex;
	var item = job.items[ itemIndex ];
	
	var deltag = item.source + " " + item.date + " " + item.page + "\n\n" + item.title;
	
	if ((deltag.trim() == "") || confirm("Wollen Sie diesen Artikel löschen?\n\n" + deltag))
	{
		delete bestell.selectedItem;

		job.items.splice(itemIndex, 1);
		
		bestell.updateItems();
		bestell.saveContext();
		
		bestell.updateRemoteItem("d", job, item);
	}
}

bestell.sendJob = function(event)
{
	event.preventDefault();

	var jobIndex = event.target.jobIndex;
	var job = bestell.context.jobs[ jobIndex ];
	
	var deltag = bestell.fullDateHuman(job.date);
	
	if (confirm("Wollen Sie diesen Auftrag versenden?\n\n" + deltag))
	{
		bestell.sendftpRemoteJob(job);
	}
}

bestell.removeJob = function(event)
{
	event.preventDefault();

	var jobIndex = event.target.jobIndex;
	var job = bestell.context.jobs[ jobIndex ];
	
	var deltag = bestell.fullDateHuman(job.date);
	
	if (confirm("Wollen Sie diesen Auftrag löschen?\n\n" + deltag))
	{
		bestell.context.jobs.splice(jobIndex, 1);
		
		if (bestell.selectedJob >= jobIndex)
		{
			delete bestell.selectedJob;
			delete bestell.selectedItem;
			
			if (--jobIndex >= bestell.context.jobs.length)
			{
				bestell.selectedJob = jobIndex;
			}
		}
		
		bestell.updateJobs();
		bestell.saveContext();
		
		bestell.updateRemoteJob("d", job);
	}
}

bestell.createSachSelect = function(inputSize, value)
{
	var sachInput = document.createElement("select");
	sachInput.style.width = "18%";
	sachInput.style.height = "90%";
	sachInput.style.border = "0px";
	sachInput.style.margin = "0px";
	sachInput.style.marginRight = "4px";
	sachInput.style.padding = "0px";
	sachInput.style.fontSize = inputSize;
	sachInput.value = value;
	sachInput.onchange = bestell.onInputChanged;

	var option = document.createElement("option");
	option.value = "";
	option.text  = "";
	sachInput.add(option);
	
	var sach = bestell.context.sach;
			
	for (var fnz = 0; fnz < sach.length; fnz++)
	{
		var option = document.createElement("option");
		
		option.value = sach[ fnz ];
		option.text  = sach[ fnz ];
		
		sachInput.add(option);
		
		if (option.value == value)
		{
			sachInput.selectedIndex = fnz + 1;
		}
	}

	return sachInput;
}

bestell.validateItem = function(item)
{
	var date = item.date.split(".");
	
	if (date.length == 2) 
	{
		item.date += ".2016";
		bestell.dateInput.value = item.date;
	}
	
	item.ok = item.source.length && item.date.length && item.page.length && item.title.length;

	var date = item.date.split(".");
	var dateok = false;
	
	if (date.length == 3)
	{
		console.log("bestell.validateItem: " + item.date);
		
		try
		{
			var day   = parseInt(date[ 0 ], 10);
			var month = parseInt(date[ 1 ], 10);
			var year  = parseInt(date[ 2 ], 10);
			
			var checkdate = new Date(year, month - 1, day);
			
			dateok = (checkdate.getFullYear() == year) &&
					 (checkdate.getMonth() + 1 == month) &&
					 (checkdate.getDate() == day);

			console.log("bestell.validateItem: dateok=" + dateok);
			
			item.date = bestell.zeroPadStringLeft(checkdate.getDate(), 2)
					  + "."
					  + bestell.zeroPadStringLeft(checkdate.getMonth() + 1, 2)
					  + "."
					  + bestell.zeroPadStringLeft(checkdate.getFullYear(), 4)
					  ;

			bestell.dateInput.value = item.date;
			dateok = true;
		}
		catch (err)
		{
		}
	}
	
	item.ok = item.ok && dateok;
}

bestell.onInputChanged = function(event)
{
	if (! bestell.hasOwnProperty("selectedJob")) return;
	var job = bestell.context.jobs[ bestell.selectedJob ];

	if (! bestell.hasOwnProperty("selectedItem")) return;
	var item = job.items[ bestell.selectedItem ];
	
	item.source = bestell.sourceInput.value;
	item.date = bestell.dateInput.value;
	item.page = bestell.pageInput.value;
	
	var sg1 = bestell.sachInput1.value;
	var sg2 = bestell.sachInput2.value;
	var sg3 = bestell.sachInput3.value;
	var sg4 = bestell.sachInput4.value;
	var sg5 = bestell.sachInput5.value;
	
	item.sach = "";
	
	if (sg1.length) item.sach += ((item.sach.length > 0) ? ", " : "") + sg1;
	if (sg2.length) item.sach += ((item.sach.length > 0) ? ", " : "") + sg2;
	if (sg3.length) item.sach += ((item.sach.length > 0) ? ", " : "") + sg3;
	if (sg4.length) item.sach += ((item.sach.length > 0) ? ", " : "") + sg4;
	if (sg5.length) item.sach += ((item.sach.length > 0) ? ", " : "") + sg5;
	
	item.title = bestell.titleInput.value;
	item.notes = bestell.notesInput.value;
	
	bestell.validateItem(item);
	bestell.saveContext();
	
	bestell.updateRemoteItem("u", job, item);
	
	var itemDiv = event.target.parentNode.parentNode.parentNode;
	itemDiv.style.backgroundColor = item.ok ? "#bbffbb" : "#ffbbbb";
}

bestell.updateItems = function()
{
	var itemsContent = bestell.itemsContent;
	itemsContent.innerHTML = null;

	if (! bestell.hasOwnProperty("selectedJob")) return;
	var job = bestell.context.jobs[ bestell.selectedJob ];
	if (! job.hasOwnProperty("items")) job.items = [];
	
	bestell.itemsNew.style.display = job.send ? "none" : "block";
	
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

		selected = selected && ! job.send;
		
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
		sourceDiv.style.right = "68%";
  		sourceDiv.style.overflow = "hidden";
		sourceDiv.style.whiteSpace = "nowrap";
  		sourceDiv.style.textOverflow = "ellipsis";
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

			sourceInput.onchange = bestell.onInputChanged;
			
			var sources = bestell.context.sources;
			
			var option = document.createElement("option");
			option.value = "";
			option.text  = "";
			sourceInput.add(option);

			var cnt = 1;
			
			for (var prop in sources)
			{
				var option = document.createElement("option");
				
				option.value = prop + " - " + sources[ prop ];
				option.text  = prop + " - " + sources[ prop ];
				
				sourceInput.add(option);

				if (option.value == item.source)
				{
					sourceInput.selectedIndex = cnt;
				}
				
				cnt++;
			}
			        
			sourceDiv.appendChild(sourceInput);
			bestell.sourceInput = sourceInput;
		}
		else
		{
			sourceDiv.innerHTML = item.source;
		}
		
		var dateDiv = document.createElement("div");
		dateDiv.style.position = "absolute";
		dateDiv.style.top = "0%";
		dateDiv.style.left = "34%";
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
			dateInput.value = item.date;
			dateInput.placeholder = "Datum";
			dateInput.onchange = bestell.onInputChanged;

			dateDiv.appendChild(dateInput);
			bestell.dateInput = dateInput;
		}
		else
		{
			dateDiv.innerHTML = item.date;
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
			pageInput.value = item.page;
			pageInput.placeholder = "Seite";
			pageInput.onchange = bestell.onInputChanged;
			
			pageDiv.appendChild(pageInput);
			bestell.pageInput = pageInput;
		}
		else
		{
			pageDiv.innerHTML = item.page;
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
			var sach = item.sach.split(", ");
			
			bestell.sachInput1 = bestell.createSachSelect(inputSize, sach[ 0 ]);
			bestell.sachInput2 = bestell.createSachSelect(inputSize, sach[ 1 ]);
			bestell.sachInput3 = bestell.createSachSelect(inputSize, sach[ 2 ]);
			bestell.sachInput4 = bestell.createSachSelect(inputSize, sach[ 3 ]);
			bestell.sachInput5 = bestell.createSachSelect(inputSize, sach[ 4 ]);
			
			sachDiv.appendChild(bestell.sachInput1);
			sachDiv.appendChild(bestell.sachInput2);
			sachDiv.appendChild(bestell.sachInput3);
			sachDiv.appendChild(bestell.sachInput4);
			sachDiv.appendChild(bestell.sachInput5);
		}
		else
		{
			sachDiv.innerHTML = item.sach;
		}
		
		var titleDiv = document.createElement("div");
		titleDiv.style.position = "absolute";
		titleDiv.style.top = "0%";
		titleDiv.style.left = "2%";
		titleDiv.style.bottom = "0%";
		titleDiv.style.right = "42%";
  		titleDiv.style.overflow = "hidden";
		titleDiv.style.whiteSpace = "nowrap";
  		titleDiv.style.textOverflow = "ellipsis";
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
			titleInput.value = item.title;
			titleInput.placeholder = "Titelanriss";
			titleInput.onchange = bestell.onInputChanged;

			titleDiv.appendChild(titleInput);
			bestell.titleInput = titleInput;
		}
		else
		{
			titleDiv.innerHTML = item.title;
		}
		
		var notesDiv = document.createElement("div");
		notesDiv.style.position = "absolute";
		notesDiv.style.top = "0%";
		notesDiv.style.left = "60%";
		notesDiv.style.bottom = "0%";
		notesDiv.style.right = "40px";
  		notesDiv.style.overflow = "hidden";
		notesDiv.style.whiteSpace = "nowrap";
  		notesDiv.style.textOverflow = "ellipsis";
		itemLine2.appendChild(notesDiv);
		
		if (selected)
		{
			var notesInput = document.createElement("input");
			notesInput.style.width = "100%";
			notesInput.style.height = "90%";
			notesInput.style.border = "0px";
			notesInput.style.margin = "0px";
			notesInput.style.padding = "0px";
			notesInput.style.fontSize = inputSize;
			notesInput.type = "text";
			notesInput.value = item.notes;
			notesInput.placeholder = "Hinweise";
			notesInput.onchange = bestell.onInputChanged;

			notesDiv.appendChild(notesInput);
			bestell.notesInput = notesInput;
		}
		else
		{
			notesDiv.innerHTML = item.notes;
		}
				
		if (! job.send)
		{
			var itemDeleteIcon = document.createElement("img");
			itemDeleteIcon.style.position = "absolute";
			itemDeleteIcon.style.top = "15px";
			itemDeleteIcon.style.right = "5px";
			itemDeleteIcon.style.width = "20px";
			itemDeleteIcon.style.height = "20px";
			itemDeleteIcon.src = "images/remove.png";
			itemDeleteIcon.onclick = bestell.removeItem;
			itemDeleteIcon.itemIndex = inx;
			itemDiv.appendChild(itemDeleteIcon);
		}
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
		jobDate.innerHTML = bestell.fullDateHuman(job.date);
		jobDiv.appendChild(jobDate);
		
		if (job.send)
		{
			jobDate.style.lineHeight = "40px";
			
			var jobSend = document.createElement("center");
			jobSend.style.lineHeight = "0px";
			jobSend.style.fontSize = "12px";
			jobSend.innerHTML = "Bestellt: " + bestell.fullDateHuman(job.send);
			jobDiv.appendChild(jobSend);
		}
		
		if (! job.send)
		{
			var jobSendIcon = document.createElement("img");
			jobSendIcon.style.position = "absolute";
			jobSendIcon.style.top = "15px";
			jobSendIcon.style.left = "5px";
			jobSendIcon.style.width = "20px";
			jobSendIcon.style.height = "20px";
			jobSendIcon.src = "images/send.png";
			jobSendIcon.onclick = bestell.sendJob;
			jobSendIcon.jobIndex = inx;
			jobDiv.appendChild(jobSendIcon);

			var jobDeleteIcon = document.createElement("img");
			jobDeleteIcon.style.position = "absolute";
			jobDeleteIcon.style.top = "15px";
			jobDeleteIcon.style.right = "5px";
			jobDeleteIcon.style.width = "20px";
			jobDeleteIcon.style.height = "20px";
			jobDeleteIcon.src = "images/remove.png";
			jobDeleteIcon.onclick = bestell.removeJob;
			jobDeleteIcon.jobIndex = inx;
			jobDiv.appendChild(jobDeleteIcon);
		}
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
	userInput.value = "Test-Kappa"; 
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
	passInput.value = "test"; 
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
			+ bestell.zeroPadStringLeft(day, 2)
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
	
	delete bestell.selectedJob;
	delete bestell.selectedItem;
	
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
	bestell.updateJobs();
}

bestell.sendftpCallback = function(ok, jobname)
{
	console.log("bestell.sendftpCallback: ok=" + ok + " jobname=" + jobname);
	
	if (! ok)
	{
		alert("Versenden fehlgeschlagen:\n\n" + jobname);
		
		return;
	}

	var jobs = bestell.context.jobs;
	
	for (var inx = 0; inx < jobs.length; inx++)
	{
		var job = jobs[ inx ];
		
		if (job.name == jobname)
		{
			job.send = Math.floor(new Date().getTime() / 1000);
			
			bestell.updateJobs();
			bestell.saveContext();
	
			bestell.updateRemoteJob("u", job);
			
			break;
		}
	}
}

bestell.updateCallback = function(ok, jobname)
{
	console.log("bestell.updateCallback: ok=" + ok + " jobname=" + jobname);
	
	if (! ok)
	{
		alert("Speichern fehlgeschlagen:\n\n" + jobname);
		
		return;
	}
}

bestell.requestJavascript = function(url)
{
	console.log("bestell.requestJavascript: url=" + url);
	
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











