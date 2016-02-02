

function showDiv() {
    var isShowing = document.getElementById("loginDiv").style.visibility;

    if (isShowing === "visible") {
        //document.getElementById("diceAreaInner").innerHTML = "visible";
        document.getElementById("loginDiv").style.visibility = "hidden";
    } else if (isShowing === "hidden") {
        //document.getElementById("diceAreaInner").innerHTML = "hidden";
        document.getElementById("loginDiv").style.visibility = "visible";
    }

}

function insertItem(id) {
    var card_id = id;
    var collection_id = 'collection' + id;
    var collection_id = document.getElementById(collection_id).value;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("response" + id).innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", ".?action=addcollectionitem&card_id=" + card_id + "&collection_id=" + collection_id);
    xmlhttp.send();

}

function editCollection(id) {
    var collection_id = id;

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("valuediv").innerHTML = xmlhttp.responseText;
            get_values();
        }
    }
    xmlhttp.open("GET", ".?action=changecollection&collectionid=" + collection_id);
    xmlhttp.send();

}

function get_values() {

    var name = document.getElementById("namevalue").innerHTML;
    var desc = document.getElementById("descvalue").innerHTML;
    var public = document.getElementById("publicvalue").innerHTML;
    var priority = document.getElementById("priorityvalue").innerHTML;

    document.getElementById("name").value = name;
    document.getElementById("desc").value = desc;
    document.getElementById("priority").value = priority;

    if (public == 1) {
        document.getElementById("public").checked = true;
    } else {
        document.getElementById("public").checked = false;
    }

}

function get_price() {
    var card_name = document.getElementById("card_name").innerHTML;
    var set_name = document.getElementById("set_name").innerHTML;

    //window.alert("Get Price Called");

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var result = xmlhttp.responseText;
            document.getElementById("price_area").innerHTML = result;
            get_price_foil();
        }
    };
    xmlhttp.open("GET", ".?action=getprice&card_name=" + card_name + "&set_name=" + set_name);
    xmlhttp.send();
}

function get_price_foil() {
    var card_name = document.getElementById("card_name").innerHTML;
    var set_name = document.getElementById("set_name").innerHTML;

    //window.alert("Get Price Foil Called");

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var result = xmlhttp.responseText;
            document.getElementById("price_area_foil").innerHTML = "Foil: " + result;
        }
    };
    xmlhttp.open("GET", ".?action=getprice&foil=true&card_name=" + card_name + "&set_name=" + set_name);
    xmlhttp.send();
}

function findMatches(searchValue) {
    //window.alert("findMatches Called "+searchValue);
    var length = searchValue.length;
    if (length >= 3) {
        //window.alert("findMatches Called "+searchValue);

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var result = xmlhttp.responseText;
                document.getElementById("searchResultsArea").innerHTML = result;
            }
        };
        xmlhttp.open("GET", ".?action=ajaxsearch&searchvalue=" + searchValue);
        xmlhttp.send();
    }
}

function addCard(card_id,rownum,playerNumber,isFoil) {
//    console.log(card_id);
//    console.log(rownum);
//    console.log(playerNumber);
//    console.log(isFoil);
    
    var cardName = document.getElementById("name"+rownum).innerHTML;
    var setCode = document.getElementById("code"+rownum).innerHTML;  
    var innerText = cardName + " - " + setCode;
    
//    console.log(cardName);
//    console.log(setCode);
    
    if(playerNumber === "player1"){
        parentTable = document.getElementById("cardArea1");
        //console.log(parentTable);
    }else{
        parentTable = document.getElementById("cardArea2");
        //console.log(parentTable);
    }
  
    var row = document.createElement("tr");
    var nameArea = document.createElement("td");
    nameArea.innerHTML = innerText;
    row.appendChild(nameArea);
    var priceArea = document.createElement("td");
    row.appendChild(priceArea);
    parentTable.appendChild(row);
}