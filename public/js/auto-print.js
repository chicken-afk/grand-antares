function getData() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/auto-print`,
        type: "GET",
        success: function (response) {
            localStorage.removeItem("queue_prints");
            localStorage.setItem("queue_prints", JSON.stringify(response));

            // window.location = "/products"
        },
        error: function (response) {
            console.log(response);
        }
    });
}

function changePrintedPdf(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: `/print/${id}`,
        type: "GET",
        success: function (response) {
            console.log(response);
            // window.location = "/products"
        },
        error: function (response) {
            console.log(response);
        }
    });
}

function runPrint() {
    console.log('run printingg function runPrint')
    var queue = JSON.parse(localStorage.getItem("queue_prints") || "[]");
    console.log(queue)
    var lenghtPrint = queue.length;
    console.log('lenght =' + lenghtPrint)
    if (lenghtPrint > 0) {
        console.log('lenght > 0')
        var readyPrint = queue[0];
        print(readyPrint.printer, readyPrint.paper, readyPrint.invoice_pdf);
        changePrintedPdf(readyPrint.id);
        getData();
    } else {
        console.log('get dataa')
        getData();
    }
}

var clientPrinters = null;
var _this = this;

//WebSocket settings
JSPM.JSPrintManager.auto_reconnect = true;
JSPM.JSPrintManager.start();

//Check JSPM WebSocket status
function jspmWSStatus() {
    if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Open) {
        console.log('true');
        return true;
    }
    else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Closed) {
        console.log('else if')
        alert(
            'JSPrintManager (JSPM) is not installed or not running! Download JSPM Client App from https://neodynamic.com/downloads/jspm'
        );
        return false;
    } else if (JSPM.JSPrintManager.websocket_status == JSPM.WSStatus.Blocked) {
        console.log('else if 2')
        alert('JSPM has blocked this website!');
        return false;
    }
}

//Do printing...
function print(printerName, paper, pdf) {
    console.log('masuk printing')
    if (jspmWSStatus()) {
        console.log('masuk if')

        //Create a ClientPrintJob
        var cpj = new JSPM.ClientPrintJob();

        //Set Printer info
        var myPrinter = new JSPM.InstalledPrinter(printerName);
        myPrinter.paperName = paper;

        cpj.clientPrinter = myPrinter;

        //Set PDF file
        var my_file = new JSPM.PrintFilePDF(pdf, JSPM.FileSourceType.URL, 'MyFile.pdf', 1);


        cpj.files.push(my_file);

        //Send print job to printer!
        cpj.sendToClient();

        return true;

    }
}