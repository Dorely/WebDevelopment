<nav role="navigation">
    <div>
        <ul>
            <li class="welcome"><?php echo 'Welcome ' . $name; ?> </li>
        </ul>
        <ul>
            
            <li><form>
                    <input class="navButton" type = "button" onclick = "showDiv()" value="Dice Emulator">
                </form></li>
            <li class="navigation"><a href=".?action=loggedon" title="Go to the User Homepage">Home</a></li>
            <li class="navigation"><a href=".?action=logout" title="Logout">Logout</a></li>
            <li class="navigation"><a href=".?action=manageaccount" title="Manage Account">Manage Account</a></li>
        </ul>

    </div>
    <div id="diceArea" style="visibility: hidden;" >
         <script src="/javascript/diceEmulator.js"></script> 
        <div id="diceAreaInner">
            <form>
                <table id="resultsArea">

                    <tr>
                        <td>D4s</td>
                        <td>D6s</td>
                        <td>D8s</td>
                        <td>D10s</td>
                        <td>D10%s</td>
                        <td>D12s</td>
                        <td>D20s</td>
                    </tr>
                    <tr>
                        <td><input type="number" id="d4number" value="0"></td>
                        <td><input type="number" id="d6number" value="0"></td>
                        <td><input type="number" id="d8number" value="0"></td>
                        <td><input type="number" id="d10number" value="0"></td>
                        <td><input type="number" id="d10Percentnumber" value="0"></td>
                        <td><input type="number" id="d12number" value="0"></td>
                        <td><input type="number" id="d20number" value="0"></td>  
                    </tr>

                </table>
               
                <input id="rollButton" type = "button" onclick = "rollDice()" value="Roll" >
                <input id="resetButton" type="button" onclick="removeRows()" value="Reset" disabled>
            </form>
        </div>
        
    </div>
</nav>