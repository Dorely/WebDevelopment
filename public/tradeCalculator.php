<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/nav.php'; ?>
<main role="main">
    <h1>Trade Calculator</h1>
    <table>
        <tr><td>Person 1</td><td>Person 2</td></tr>
        <tr>
            <td>
                <table id="cardArea1">
                    <tr>
                        <td>Card Name</td>
                        <td>Value</td>
                    </tr>
                </table>
            </td>
            <td>
                <table id="cardArea2">
                    <tr>
                        <td>Card Name</td>
                        <td>Value</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td>Total:<div id="total1"></div></td><td>Total:<div id="total2"></div></td></tr>
        <tr >
            <td colspan="2">
            <input type="text" placeholder="Search For Card" onkeyup="findMatches(this.value)">
            <table id="searchResultsArea"></table>
            </td>
        </tr>
    </table>

</main>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/library/modules/footer.php'; ?>     
