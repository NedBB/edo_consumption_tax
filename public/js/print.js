let fullUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : "") + "/";
let timeout;





    document.addEventListener('DOMContentLoaded', () => {

        const input = document.getElementById('amountInput');
        let debounceTimer;

        // Listen for the 'keyup' event
        input.addEventListener('keyup', function (event) {
            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(() => {
                const value = event.target.value; // Get the input value

                // Emit event to Livewire
                window.Livewire.dispatch('amountUpdated', { value: value });
            }, 500); // Debounce time in milliseconds
        });
    });


    function extractSelectionforPrinting(colspan, total_index,page, pvno, td_arry,col_remove){
        let header = $(window.document.body).find('h4').html();
        
        header = header.replace("/", "");

        if (document.getElementsByClassName("change").length > 0){
            document.getElementsByClassName("change")[0].textContent = "Sign";
        }


        let total = Array.from({ length: $('table.table thead th').length }).map(() => 0);

        let currentDate = new Date().toLocaleDateString('en-GB');
        currentDate = currentDate.replace(/\//g, "-");

        const clonedHeading = $('table.table thead').clone();

        // Create a new table to hold the cloned heading and selected rows
        const clonedTable = $('<table class="table"></table>');

        // Append the cloned heading to the new table
        clonedTable.append(clonedHeading);
        
        $('table.table tbody tr').each(function() {
            // Check if the checkbox in the current row is checked

            if ($(this).find('input[type="checkbox"]').prop('checked')) {
                // Clone the selected row

                const clonedRow = $(this).clone();
                clonedTable.append(clonedRow);

                td_arry.forEach(value => {
                    amount = clonedRow.find('td').eq(value).text();
                    const tdValue = parseFloat(amount.replace(/,/g, ''));
                    
                    if (!isNaN(tdValue)) {
                        total[value] += tdValue;
                    }
                })
                
            }
        });

        const clonedFooter = $('table.table tfoot').clone();

        new_total = total.slice(colspan);
        let footer = $(`<tr><td colspan="${colspan - col_remove}" class="align-right">Total</td></tr>`);
        let tds;

        new_total.forEach(function(value, index) {
            if(value == 0){
               tds = `<td></td>`;
               footer.append(tds);
            }
            else{
                tds = `<td>${value.toLocaleString()}</td>`;
                footer.append(tds);
            }
         
        });
        clonedFooter.empty()
        clonedFooter.append(footer);
        clonedTable.append(clonedFooter);
        let total_amount = total[total_index - 1];
        console.log(page);
        
        if(page =='payment'){
            printTablePaymentSchedule(header,clonedTable.html(),currentDate,page, pvno, totalAmount);
        }else{
         printSelection(header,clonedTable.html(),currentDate,page, pvno, total_amount)
        }
    }

    function extractSelectionforPrintingPS(colspan, total_index,page, pvno, td_arry,col_remove){
        let header = $(window.document.body).find('h4').html();
        
        header = header.replace("/", "");

        if (document.getElementsByClassName("change").length > 0){
            document.getElementsByClassName("change")[0].textContent = "Sign";
        }


        let total = Array.from({ length: $('table.table thead th').length }).map(() => 0);
        let totalAmount = 0;
        let currentDate = new Date().toLocaleDateString('en-GB');
        currentDate = currentDate.replace(/\//g, "-");
        let count = 0;

        const clonedHeading = $('table.table thead').clone();

        // Create a new table to hold the cloned heading and selected rows
        const clonedTable = $('<table class="table"></table>');

        // Append the cloned heading to the new table
        clonedTable.append(clonedHeading);
        
        $('table.table tbody tr').each(function() {
            // Check if the checkbox in the current row is checked

            if ($(this).find('input[type="checkbox"]').prop('checked')) {
                // Clone the selected row

                const clonedRow = $(this).clone();
                clonedTable.append(clonedRow);
                
                td_arry.forEach(value => {
                    //amount = clonedRow.find('td').eq(value).text();
                    amount = clonedRow.find('td.amount').text();
                    
                    const tdValue = parseFloat(amount.replace(/,/g, ''));
                    
                    
                    if (!isNaN(tdValue)) {
                        totalAmount += tdValue;
                    }

                    
                })
                
            }
        });
     
        const clonedFooter = $('table.table tfoot').clone();

        if(page == "payment"){
             totalAmount = totalAmount / 2;
        }

        let total_format = new Intl.NumberFormat('en-US',{
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(totalAmount);

        new_total = total.slice(colspan);

        amount = (page == "payment") ? total_format : ""

        let footer = $(`<tr><td colspan="${colspan - col_remove}" class="align-right">Total</td><td>${total_format}</td><td>${amount}</td></tr>`);

        let tds;

        // new_total.forEach(function(value, index) {
        //     if(value == 0){
        //        tds = `<td></td>`;
        //        footer.append(tds);
        //     }
        //     else{
        //         tds = `<td>${totalAmount.toLocaleString()}</td>`;
        //         footer.append(tds);
        //     }
         
        // });
        clonedFooter.empty()
        clonedFooter.append(footer);
        clonedTable.append(clonedFooter);
        let total_amount = total[total_index - 1];
        //console.log(totalAmount);
        console.log(page);
        if(page =='payment'){
            printTablePaymentSchedule(header,clonedTable.html(),currentDate,totalAmount,page, pvno);
        }
        else{
            printSelection(header,clonedTable.html(),currentDate,page, pvno, totalAmount);
        }
    }

    function delayedSync(event) {
        // Clear any previous timeout to ensure only the latest input triggers the sync
        clearTimeout(timeout);

        // Set a new timeout to delay syncing with Livewire (5 seconds)
        timeout = setTimeout(function() {
            // Emit the value to Livewire after 5 seconds
            //@this.set('amount', event.target.value); // Directly update Livewire property
            Livewire.find('{{ $this->id }}').set('amount', event.target.value);
        }, 6000); // 5000 ms = 5 seconds
    }

    function updateInputValue(event) {
         // Get current input value
         let inputValue = event.target.value;

         // If the value is a valid number with a decimal
         if (/^\d*\.?\d*$/.test(inputValue)) {
             event.target.setAttribute('value', inputValue); // Ensure value stays in input
         }
 
         // Handle cursor placement when typing (fix any issues with cursor jumping)
         const cursorPosition = event.target.selectionStart;
         setTimeout(function() {
             event.target.selectionStart = cursorPosition;
             event.target.selectionEnd = cursorPosition;
         }, 0);
    }
    
    function extractContentForPrinting(colspan,page, pvno_data=null){
        let header = $(window.document.body).find('h4').html();
        header = header.replace("/", "");

        if (document.getElementsByClassName("change").length > 0){
            document.getElementsByClassName("change")[0].textContent = "Sign";
        }

        let record = $("#total_words").data("total");
        if(record == undefined){
            
        }
        console.log(record);
        
        let total_in_words = '';
        if(record != null){
            total_in_words = numberToEnglishKobo(record);
        }
        let currentDate = new Date().toLocaleDateString('en-GB');
        currentDate = currentDate.replace(/\//g, "-");

        //var newTable = $(window.document.body).find('table').html();
        var table = $(document.body).find('table:first');
        
        var $footer = table.find('tfoot');
        $footer.find('td:first').attr('colspan', colspan);

        var newTable = $(window.document.body).find('table').html();  
        console.log(page+" - "+record);
                              
        if(page == "plain"){
            printPlainTable(header, newTable);
        }
        else if(page =='payment'){
            printTablePaymentSchedule(header,newTable,currentDate, record, page, pvno_data);
        }
        else{
            printTableTpl(header, newTable,currentDate, colspan, total_in_words, page, pvno_data);
        }
    }

    function numberToEnglish(n, custom_join_character) {



        var string = n.toString(),
    
            units, tens, scales, start, end, chunks, chunksLen, chunk, ints, i, word, words;
    
    
    
        var and = custom_join_character || 'and';
    
    
    
        /* Is number zero? */
    
        if (parseInt(string) === 0) {
    
            return 'zero';
    
        }
    
    
    
        /* Array of units as words */
    
        units = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    
    
    
        /* Array of tens as words */
    
        tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    
    
    
        /* Array of scales as words */
    
        scales = ['', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quatttuor-decillion', 'quindecillion', 'sexdecillion', 'septen-decillion', 'octodecillion', 'novemdecillion', 'vigintillion', 'centillion'];
    
    
    
        /* Split user arguemnt into 3 digit chunks from right to left */
    
        start = string.length;
    
        chunks = [];
    
        while (start > 0) {
    
            end = start;
    
            chunks.push(string.slice((start = Math.max(0, start - 3)), end));
    
        }
    

        /* Check if function has enough scale words to be able to stringify the user argument */
    
        chunksLen = chunks.length;
    
        if (chunksLen > scales.length) {
    
            return '';
    
        }
    
    
    
        /* Stringify each integer in each chunk */
    
        words = [];
    
        for (i = 0; i < chunksLen; i++) {
    
    
    
            chunk = parseInt(chunks[i]);
    
    
    
            if (chunk) {
    
    
    
                /* Split chunk into array of individual integers */
    
                ints = chunks[i].split('').reverse().map(parseFloat);
    
    
    
                /* If tens integer is 1, i.e. 10, then add 10 to units integer */
    
                if (ints[1] === 1) {
    
                    ints[0] += 10;
    
                }
    
    
    
                /* Add scale word if chunk is not zero and array item exists */
    
                if ((word = scales[i])) {
    
                    words.push(word);
    
                }
    
    
    
                /* Add unit word if array item exists */
    
                if ((word = units[ints[0]])) {
    
                    words.push(word);
    
                }
    
    
    
                /* Add tens word if array item exists */
    
                if ((word = tens[ints[1]])) {
    
                    words.push(word);
    
                }
    
    
    
                /* Add 'and' string after units or tens integer if: */
    
                if (ints[0] || ints[1]) {
    
    
    
                    /* Chunk has a hundreds integer or chunk is the first of multiple chunks */
    
                    if (ints[2] || !i && chunksLen) {
    
                        words.push(and);
    
                    }
    
    
    
                }
    
    
    
                /* Add hundreds word if array item exists */
    
                if ((word = units[ints[2]])) {
    
                    words.push(word + ' hundred');
    
                }
    
    
    
            }
    
    
    
        }
    
    
    
        var result = words.reverse().join(' ');
    
        var strLenAgain = string.length;
    
        //console.log(strLenAgain);
    
        if(strLenAgain <= 3 ){
    
            var parts = result.split(' ');
    
            
    
            parts.shift(); // parts is modified to remove first word
    
            var result;
    
            if (parts instanceof Array) {

                result = parts.join(' ');

            }
    
            else {
                result = parts;
            }
        }
        return result;
    
    
    
    }
    
    function numberToEnglishKobo(num, separator){

        //Separator value
        var sepa = separator || 'and';
    
        //First we unformat money
        var nowIsNum = num;
        //We have to get the decimal value first;
        var arrKobo = nowIsNum.toString().split('.');
        var koboWord = '';
        if(arrKobo[1]){
            koboWord = numberToEnglish(arrKobo[1])+' kobo';
        }
        return '<span style="text-transform:capitalize">'+ numberToEnglish(Number(arrKobo[0].replace(/[^0-9\.-]+/g,""))) + ' Naira,' + ' ' + koboWord +' only</span>';
    }

    function isModalLoaded() {
        let modal = document.getElementById('printable');
        return modal.classList.contains('show'); // 'show' class means it's visible
    }

    function printData(){
        
        
        // $(function() {
        //     $('.print').on('click', function(e) {
        //         e.preventDefault()
                $("#printable").print("#printable");
            // });
    
           // $('.inWord').html(numberToEnglishKobo(data));
        // });
    }

    function printTableTpl(newH1, newTable,currentDate, colspan, record = '', page, pvno =null) {
        let header;
        console.log(record);
        
        //if(pvno != null && page == 'omnibus'){
        if ((pvno != null) && (page == 'omnibus' || page == 'allocation')){
           header  = `<div class="mb-3">Date: ${currentDate}</div>
            
            <div class="d-flex justify-content-between">
                <div>P.V No: ${pvno}</div>
                <div style="width:150px">Cheque No: .............................................</div>
            </div>
            `
        }
        else{
            header = `<div class="d-flex justify-content-between">
            <div>Date: ${currentDate}</div>
            <div style="width:150px">Cheque No: .............................................</div>
            </div>`
        }
        

        var newWindow = window.open("", "_blank");
        newWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>

                <title>${newH1}</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"/>
                <link rel="stylesheet" href="${fullUrl}css/main.css?v=${Date.now()}" />
                <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    body {
                        font-family: 'Ubuntu', sans-serif !important;
                        color: #666;
                    }
                    th,td{
                        color #666 !important
                    }
                    .table{
                        color: #666 !important;
                    }

                    .remove{
                        display: none !important;
                    }
                </style>
            </head>
            <body class="dt-print-view">
                
            </body>
            </html>
        `);
        $(newWindow.document.body).css('background-color', '#fff').prepend(`
            <div class="container-fluid print-view">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <div class="print-header" style="padding: 0px 10px 7px; background-color:#009688 !important;-webkit-print-color-adjust: exact; display:inline-block">
                            <div class="text-uppercase text-center m" style="text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;">Nigerian Union Of Pensioners</div>
                            <div class="text-uppercase s" style="text-align:right">National HeadQuarter</div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h2 class="text-center mt-2" style="font-size:25px; font-weight:500">${newH1}</h2><br>
                        ${header}
                        
                    </div>
                    <div class="col-lg-12 mt-3">
                        <table class="table table-hover table-bordered font-13 nowrap dataTable" id="print_table">
                            ${newTable}
                        </table><br>
                        <div class="row">
                        <div class="col-md-12 mb-2">
                                ${record}
                            </div>
                            <div class="col-md-12">
                                <em>We certify that the above statement is correct that the amount involved is in the interest of Nigeria Union of Pensioners and that the amount can be paid</em>
                            </div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-md-3">Prepared by:......................</div>
                            <div class="col-md-3">Checked by:.................<br>National Treasurer</div>
                            <div class="col-md-3">........................<br>General Secretary</div>
                            <div class="col-md-3">.........................<br>National President</div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    
    }

    function printPlainTable(newH1, newTable) {

        var newWindow = window.open("", "_blank");
        newWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>

                <title>${newH1}</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"/>
                <link rel="stylesheet" href="${fullUrl}css/main.css?v=${Date.now()}" />
                <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    body {
                        font-family: 'Ubuntu', sans-serif !important;
                        color: #666;
                    }
                    th,td{
                        color #666 !important
                    }
                    .table{
                        color: #666 !important;
                    }
                    .remove{
                        display: none !important;
                    }
                </style>
            </head>
            <body class="dt-print-view">
                
            </body>
            </html>
        `);
        $(newWindow.document.body).css('background-color', '#fff').prepend(`
            <div class="container-fluid print-view">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <div class="print-header" style="padding: 0px 10px 7px; background-color:#009688 !important;-webkit-print-color-adjust: exact; display:inline-block">
                            <div class="text-uppercase text-center m" style="text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;">Nigerian Union Of Pensioners</div>
                            <div class="text-uppercase s" style="text-align:right">National HeadQuarter</div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h2 class="text-center mt-2" style="font-size:25px; font-weight:500">${newH1}</h2><br>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <table class="table table-hover table-bordered font-13 nowrap dataTable" id="print_table">
                            ${newTable}
                        </table><br>
                    </div>
                </div>
            </div>
        `);
    }

    function printSelection(newH1, newTable,currentDate,page, pvno,amount){
        var newWindow = window.open("", "_blank");     
       
        let total = (amount != null) ? numberToEnglishKobo(amount) : ''

        if((pvno != null) && (page == 'omnibus' || page == 'allocation')){
            //var total = numberToEnglishKobo(amount)
            var record = `<div class='mb-2'>Date:${currentDate}</div>
                            <div class="d-flex justify-content-between">
                <div>P.V No: ${pvno}</div>
                <div style="width:150px">Cheque No: .............................................</div>
            </div>`;
                            // <div class="float-start">P.V No: ${pvno}</div>
                            // <div class="float-end">Cheque No:  .....................</div>
        }
        else{
           // var total = (amount !== null) ? numberToEnglishKobo(amount) : '';
            // var record = `<div class='float-start'>Date:${currentDate}</div>
            //                 <div class="float-end">Cheque No:  ......................</div>`;
            record = `<div class="d-flex justify-content-between">
            <div>Date: ${currentDate}</div>
            <div style="width:150px">Cheque No: .............................................</div>
            </div>`
        }
     
        newWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>

                <title>${newH1}</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"/>
                <link rel="stylesheet" href="${fullUrl}css/main.css?v=${Date.now()}" />
                <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    body {
                        font-family: 'Ubuntu', sans-serif !important;
                        color: #666;
                    }
                    th,td{
                        color #666 !important
                    }
                    .table{
                        color: #666 !important;
                    }
                    .no-print{
                        display: none !important;
                    }
                    .remove{
                        display: none !important;
                    }
                </style>
            </head>
            <body class="dt-print-view">
                
            </body>
            </html>
        `);
        $(newWindow.document.body).css('background-color', '#fff').prepend(`
            <div class="container-fluid print-view">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <div class="print-header" style="padding: 0px 10px 7px; background-color:#009688 !important;-webkit-print-color-adjust: exact; display:inline-block">
                            <div class="text-uppercase text-center m" style="text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;">Nigerian Union Of Pensioners</div>
                            <div class="text-uppercase s" style="text-align:right">National HeadQuarter</div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <h2 class="text-center mt-2" style="font-size:25px; font-weight:500">${newH1}</h2><br>
                        ${record}
                    </div>
                    <table class="table table-hover table-bordered font-13 nowrap dataTable" id="print_table">
                            ${newTable}
                        </table><br>
                   <div class="col-lg-12 mt-3">
                        
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                ${total}
                            </div>
                            <div class="col-md-12">
                                <em>We certify that the above statement is correct that the amount involved is in the interest of Nigeria Union of Pensioners and that the amount can be paid</em>
                            </div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-md-3">Prepared by:......................</div>
                            <div class="col-md-3">Checked by:.................<br>National Treasurer</div>
                            <div class="col-md-3">........................<br>General Secretary</div>
                            <div class="col-md-3">.........................<br>National President</div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    }

    function printTablePaymentSchedule(newH1, newTable,currentDate, amount, record = '', page, pvno =null) {
        let header;
        
           header  = `<div class="mb-3">Date: ${currentDate}</div>
            `
        let total = (amount != null) ? numberToEnglishKobo(amount) : ''
        
        var newWindow = window.open("", "_blank");
        newWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>

                <title>${newH1}</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"/>
                <link rel="stylesheet" href="${fullUrl}css/main.css?v=${Date.now()}" />
                <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500;600;700&display=swap" rel="stylesheet">
                <style>
                    body {
                        font-family: 'Ubuntu', sans-serif !important;
                        color: #666;
                    }
                    th,td{
                        color #666 !important
                    }
                    .table{
                        color: #666 !important;
                    }

                    .remove{
                        display: none !important;
                    }
                </style>
            </head>
            <body class="dt-print-view">
                
            </body>
            </html>
        `);
        $(newWindow.document.body).css('background-color', '#fff').prepend(`
            <div class="container-fluid print-view">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <div class="print-header" style="padding: 0px 10px 7px; background-color:#009688 !important;-webkit-print-color-adjust: exact; display:inline-block">
                            <div class="text-uppercase text-center m" style="text-shadow: -1px -1px 0 #fff, 1px -1px 0 #fff, -1px 1px 0 #fff, 1px 1px 0 #fff;">Nigerian Union Of Pensioners</div>
                            <div class="text-uppercase s" style="text-align:right">National HeadQuarter</div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h2 class="text-center mt-2" style="font-size:25px; font-weight:500">${newH1}</h2><br>
                        ${header}
                        
                    </div>
                    <div class="col-lg-12 mt-3">
                        <table class="table table-hover table-bordered font-13 nowrap dataTable" id="print_table">
                            ${newTable}
                        </table><br>
                        <div class="row">
                        <div class="col-md-12 mb-2">
                                ${total}
                            </div>
                        
                        </div><br><br>
                        <div class="row">
                            <div class="col-md-3">CASH/CHEQUE NO:......................</div>
                            <div class="col-md-3">LISTED:.................</div>
                            <div class="col-md-3">SIGNATURE........................</div>
                            <div class="col-md-3">DATE.........................</div>
                        </div>
                    </div>
                </div>
            </div>
        `);
    
    }
    
