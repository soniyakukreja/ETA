<html>
<head>
    <title>Mime type checker</title>
    <script>
  
  /*
        $(function () {
            var result = $('div#result');
            if (window.FileReader && window.Blob) {
                $('span#submit').click(function () {
                    var files = $('input#file').get(0).files;

                    console.log('f',files);
                    console.log('ff',$('input#file'));
                    console.log('fff',$('input#file').get(0));


                    if (files.length > 0) {
                        var file = files[0];
                        console.log('Loaded file: ' + file.name);
                        console.log('Blob mime: ' + file.type);

                        var fileReader = new FileReader();
                        fileReader.onloadend = function (e) {
                            var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
                            var header = '';
                            for (var i = 0; i < arr.length; i++) {
                                header += arr[i].toString(16);
                            }
                            console.log('File header: ' + header);

                            // Check the file signature against known types
                            var type = 'unknown';
                            switch (header) {
                                case '89504e47':
                                    type = 'image/png';
                                    break;
                                case '47494638':
                                    type = 'image/gif';
                                    break;
                                case 'ffd8ffe0':
                                case 'ffd8ffe1':
                                case 'ffd8ffe2':
                                    type = 'image/jpeg';
                                    break;
                                case '25504446':
                                    type = 'application/pdf';
                                    break;
                            }

                            if (file.type !== type) {
                                result.html('<span style="color: red; ">Mime type detected: ' + type + '. Does not match file extension.</span>');
                            } else {
                                result.html('<span style="color: green; ">Mime type detected: ' + type + '. Matches file extension.</span>');
                            }
                        };
                        fileReader.readAsArrayBuffer(file);
                    }
                });
            } else {
                result.html('<span style="color: red; ">Your browser is not supported. Sorry.</span>');
                console.error('FileReader or Blob is not supported by browser.');
            }
        });
*/


        var counter = 0;
        async function checktype(){
            var result = success= '';
            if (window.FileReader && window.Blob) {
                    var files = $('input#file').get(0).files;
                    if (files.length > 0) {
                        var file = files[0];
                        var fileReader = new FileReader();
                        fileReader.onloadend = function (e) {
                            var arr = (new Uint8Array(e.target.result)).subarray(0, 4);
                            var header = '';
                            for (var i = 0; i < arr.length; i++) {
                                header += arr[i].toString(16);
                            }

                            // Check the file signature against known types
                            var type = 'unknown';
                            switch (header) {
                                case '89504e47':
                                    type = 'image/png';
                                    break;
                                case '47494638':
                                    type = 'image/gif';
                                    break;
                                case 'ffd8ffe0':
                                case 'ffd8ffe1':
                                case 'ffd8ffe2':
                                    type = 'image/jpeg';
                                    break;
                                case '25504446':
                                    type = 'application/pdf';
                                    break;
                            }
                            if (file.type !== type) {
                                result = 'Mime type detected: ' + type + '. Does not match file extension.';
                                success = false;
                            } else {
                                result='Mime type detected: ' + type + '. Matches file extension.';
                                success = true;
                                counter = 1;
                                console.log('finaltrue',counter);
                                $('#result').attr('valid','true');
                                return counter;
                            }
                        };
                        fileReader.readAsArrayBuffer(file);
                    }else{
                        result = 'File not selected';
                        success = false;                        
                    }
            }else{
                result ='Your browser is not supported. Sorry.';
                success = false;
            }
        }
        
        $(document).on('click','#submit',function () {
            console.log('clicked');
            typereturn = checktype();
            console.log('typereturn',typereturn);
            abc = $('#result').attr('valid');
            console.log('abc',abc);
        });
        
    </script>
    <style>
        .submit {
            border: 1px grey solid;
            padding: 3px;
            position: relative;
            top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
Check mime type of your file in one click<br>
<input type="file" id="file"><br>
<div id="result" valid="false"></div>
<span class="submit" id="submit">Check</span>
</body>
</html>