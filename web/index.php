<?php
$fonts = [];
$fontfiles = glob('fonts/*.flf');
foreach ($fontfiles as $fontfile) {
    $fonts[] = pathinfo($fontfile)['filename'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ASCII by sorta stupid</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style type="text/css">
        body {
            padding-top: 30px;
        }

        pre {
            display: inline-block;
            font-family: monospace;
            line-height: initial;
            padding: 10px;
        }

        .modal-dialog{
            position: relative;
            display: table; /* This is important */
            overflow-y: auto;
            overflow-x: auto;
            width: auto;
            min-width: 300px;
        }

    </style>
</head>
<body>
    <main role="main" class="container">
        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">boring text</div>
                  <div class="card-body">
                      <div class="form-group">
                        <textarea class="form-control" id="inputText" placeholder="Write something here" required>sorta stupid</textarea>
                      </div>
                  </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                        <div class="form-inline">
                            <span class="mr-sm-2">fun text</span>

                            <button id="btn-copy" type="button" class="mr-sm-2 btn btn-primary btn-sm" data-clipboard-target="#outputFigDisplay > pre">Copy</button>
                            <button id="btn-save" type="button" class="mr-sm-2 btn btn-primary btn-sm">Save</button>

                            <select class="mr-sm-2 form-control" id="font">
                                <?php for ($i = 0; $i < count($fonts); $i++): ?>
                                    <option value="<?php echo $i ?>"><?php echo htmlentities($fonts[$i]) ?></option>
                                <?php endfor; ?>
                            </select>

                            <button class="mr-sm-2 btn btn-sm btn-primary" id="btn-left" title="Previous font">←</button>
                            <button class="mr-sm-2 btn btn-sm btn-primary" id="btn-right" title="Next font">→</button>
                        </div>
                  </div>
                  <div class="card-body">

                    <div id="outputFigDisplay"></div>

                  </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Save image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="image"></div>
              <p><em>(right click, save image)</em></p>
          </div>
        </div>
      </div>
    </div>

<!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/3.0.0/fetch.min.js" integrity="sha256-E1M+0f/hvoNVoV8K5RSn1gwe4EFwlvORnOrFzghX0wM=" crossorigin="anonymous"></script>
-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/figlet.js"></script>
    <script type="text/javascript" src="js/clipboard.min.js"></script>
    <script type="text/javascript" src="js/html2canvas.min.js"></script>

<script>
    (function($) {
        var fonts = <?php echo json_encode($fonts) ?>;

        if (window.location.protocol === 'file:') {
            alert('fetch APi does not support file: protocol.');
        }

        figlet.defaults({
            fontPath: 'fonts'
        });

        var counter = parseInt($('#font').val());

        var update = function() {
            var fontName = fonts[counter];
            var inputText = $('#inputText').val();

            figlet(inputText, {
                font: fontName,
            }, function(err, text) {
                if (err) {
                    console.log('something went wrong...');
                    console.dir(err);
                    return;
                }
                $('#outputFigDisplay').html("<pre>" + text + "</pre>");
            });

            /*
                How to read the metadata for a font
            */
            /*
            figlet.metadata(fontName, function(err, options, headerComment) {
                if (err) {
                    console.log('something went wrong...');
                    console.dir(err);
                    return;
                }
                console.dir(options);
                console.log(headerComment);
            });
            */
        };

        $('#inputText').on('keyup', function(e) {
            update();
        });

        $(document).on('keyup', function(e) {
            if (e.keyCode == 37 /* LEFT */) {
                counter = (counter - 1 < 0) ? fonts.length : counter - 1;
                $('#font').val(counter);
                update();
            }

            else if (e.keyCode == 39 /* RIGHT */) {
                counter = counter + 1 > fonts.length ? counter = 0 : counter + 1;
                $('#font').val(counter);
                update();
            }
        });

        $('#btn-left').on('click', function() {
            counter = (counter - 1 < 0) ? fonts.length : counter - 1;
            $('#font').val(counter);
            update();
        });

        $('#btn-right').on('click', function() {
            counter = counter + 1 > fonts.length ? counter = 0 : counter + 1;
            $('#font').val(counter);
            update();
        });

        $('#font').on('change', function() {
            counter = parseInt($(this).val());
            update();
        });

        update(); // init

        var clipboard = new ClipboardJS('#btn-copy');

        $('#btn-copy').tooltip({
            title: 'Copied!',
            placement: 'bottom',
            trigger: 'manual',
        });

        clipboard.on('success', function(e) {
            $('#btn-copy').tooltip('show');
            e.clearSelection();
            setTimeout(function() {
                $('#btn-copy').tooltip('hide');
            }, 1000);
        });


        $('#btn-save').on('click', function() {
            html2canvas(document.querySelector("#outputFigDisplay > pre")).then(canvas => {
                $('#modal .modal-body .image').html('');
                $('#modal .modal-body .image').append(canvas);
                $('#modal').modal('show');
            });
        });
    })(jQuery);
</script>

</body>
</html>
