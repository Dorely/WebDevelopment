
            function showDiv() {
                var isShowing = document.getElementById("diceArea").style.visibility;

                if (isShowing === "visible") {
                    //document.getElementById("diceAreaInner").innerHTML = "visible";
                    document.getElementById("diceArea").style.visibility = "hidden";
                } else if (isShowing === "hidden") {
                    //document.getElementById("diceAreaInner").innerHTML = "hidden";
                    document.getElementById("diceArea").style.visibility = "visible";
                }

            }


            var createdElements = [];
            var high = 0;
            function rollDice() {
                
                high=0;
                var diceNumbers = [];
                diceNumbers[0] = parseInt(document.getElementById("d4number").value);
                diceNumbers[1] = parseInt(document.getElementById("d6number").value);
                diceNumbers[2] = parseInt(document.getElementById("d8number").value);
                diceNumbers[3] = parseInt(document.getElementById("d10number").value);
                diceNumbers[4] = parseInt(document.getElementById("d10Percentnumber").value);
                diceNumbers[5] = parseInt(document.getElementById("d12number").value);
                diceNumbers[6] = parseInt(document.getElementById("d20number").value);



                var diceCounter = [0, 0, 0, 0, 0, 0, 0];

                
                //find the highest number of dice, this will be how many rows to create
                for (var i = 0; i < 7; i++) {
                    if (high < diceNumbers[i]) {
                        high = diceNumbers[i];
                    }
                }

                if (high > 0) {
                    document.getElementById("rollButton").disabled = true;
                    document.getElementById("resetButton").disabled = false;
                }

                //loop through and create rows and columns
                for (var i = 0; i < high; i++) {
                    if (high > 0) {
                        //create a row in the table
                        var x = document.createElement("tr");
                        x.id = "row" + i;
                        createdElements.push(x.id);
                        document.getElementById("resultsArea").appendChild(x);
                        //create table data within the row created above 
                        for (var j = 0; j < 7; j++) {

                            var z = document.createElement("td");
                            z.id = "data" + i + "" + j;
                            createdElements.push(z.id);
                            if (diceNumbers[j] > diceCounter[j]) {

                                if (j === 0) {
                                    z.textContent = Math.floor((Math.random() * 4) + 1);
                                }
                                else if (j === 1) {
                                    z.textContent = Math.floor((Math.random() * 6) + 1);
                                }
                                else if (j === 2) {
                                    z.textContent = Math.floor((Math.random() * 8) + 1);
                                }
                                else if (j === 3) {
                                    z.textContent = Math.floor((Math.random() * 10) + 1);
                                }
                                else if (j === 4) {
                                    z.textContent = (10 * Math.floor((Math.random() * 10) + 1)) + "%";
                                }
                                else if (j === 5) {
                                    z.textContent = Math.floor((Math.random() * 12) + 1);
                                }
                                else if (j === 6) {
                                    z.textContent = Math.floor((Math.random() * 20) + 1);
                                } else {
                                    z.textContent = j; //debug output, should never hit this
                                }
                            }
                            document.getElementById("row" + i).appendChild(z);
                            diceCounter[j]++;



                        }
                    }
                }


                //var x = document.createElement("td");
                //x.textContent = d4number;
                //document.getElementById("resultsArea").appendChild(x);
            }

            function removeRows() {

                for (var i = 0; i <= createdElements.length; i++) {
                    //debug output to the console
                    console.log(createdElements[i]);
                }
                var table = document.getElementById("resultsArea");
                
                for (var i = 0; i < high; i++)
                {
                    var row = document.getElementById("row"+i);
                    
                    for(var j = 0; j < 7; j++){
                        var data = document.getElementById("data"+i+j);
                        row.removeChild(data);
                    }
                    table.removeChild(row);
                    
                }
                createdElements.length = 0;
                document.getElementById("rollButton").disabled = false;
                document.getElementById("resetButton").disabled = true;
            }

