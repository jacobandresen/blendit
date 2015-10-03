<html>
    <head>
        <title>Hack4DK 2015</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <a id="blendit" class="navbar-brand" href="#">Blendit</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li id="dinegen" class="active"><a href="#">Skriv din egen historie</a></li>
                    <li id="deandres"><a id="other" href="#historier">Se de andres historier</a></li>
                </ul>
            </div>
        </nav>

        <div id="forside" class="container">
            <div class="container">
                <div class="row">
                    <h1>Hvordan mon det var i Kolding i 1850?</h1>
                    Pr&oslash;v at forestille dig at du levede I kolding i 1850  ...
                    <div class="col-md-12" id="aagaardliste"></div>
                        <div id="natmusliste"></div>

                        <a class="btn btn-lg btn-primary" href="#" id="blend" role="button">Skriv din egen historie</a>
                    </div>
               </div>
            </div>
        </div>

        <div id="historie" class="hidden">
            <div class="container">
            <div class="row">
                <div class="col-md-12">          
                     <h3> Skriv en historie hvor disse ting indg&aring;r </h3>
                 </div>
            </div>
            <hr/><hr/>
            <div class="row">
                <div class="col-md-4" id="aagard"></div>
                <div class="col-md-4" id="kvinde"></div>
                <div class="col-md-4" id="natmus"></div>
            </div>
            <hr/>
            <div class="row pull-right">
                <form class="col-md-12">
                    <div class="form-group">
                        <label for="navn">Navn:</label>
                        <input id="navn" type="text" class="form-control" name="navn">
                    </div>
                    <div class="form-group">
                        <label for="historie">Historie:</lable>
                        <textarea id="txt" name="story" cols="80" rows="30" class="form-control"></textarea>
                    </div>
                    <span class="input-group-addon btn" id="gem">Gem</span>
                </form>
            </div>
            </div>
       </div>

       <div id="liste" class="hidden">
            <div class="container">
                <div id="indhold" class="col-md-12">
                 <?php 
                  print utf8_decode(file_get_contents("historier.txt"));
                 ?>
                </div>
            </div>
       </div>

       <script type="text/javascript">
           function visHistorier() {
               $('#indhold').load("historier.txt");
           };

           $('#blendit').click(function(evt) {
               $('#forside').show();
               $('#deandre').hide();
               $('#liste').hide();
               $('#historie').hide();
               $('#blendit').addClass("active");
               $('#dinegen').removeClass("active");
               $('#deandres').removeClass("active");
            });
            $('#blend').click(function(evt) {
                $('#forside').hide();
                $('#liste').hide();
                $('#historie').toggleClass("hidden").show();
            });
            $('#dinegen').click(function(evt) {
                $('#liste').hide();
                $('#historie').removeClass("hidden").show();
                $('#forside').hide();
                $('#blendit').removeClass("active");
                $('#deandres').removeClass("active");
                $('#dinegen').removeClass("active").addClass("active");
            });
            $('#deandres').click(function(evt) {
                evt.preventDefault();
                $('#forside').hide();
                $('#historie').hide();
                $('#liste').removeClass("hidden").show();
                $('#deandres').removeClass("active").addClass("active");
                $('#dinegen').removeClass('active');
                $('#blendit').removeClass('active');
                visHistorier();
            });
            $('#gem').click(function(evt) {
                evt.preventDefault();
                $.post(
                    "historier.php",
                     {
                        'navn': $('#navn').val(),
                        'historie': $('#txt').val()
                     }
                ).done(function(data) {
                     $('#other').trigger('click');
                       // console.log("it worked:%o", data);
                    });
            });

            function billeder() {
                function addImage (id, title) {
                    title = title.substring(4, title.length);
                      $.ajax({
                          url:  "https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=bc99e15c65aa6b50c011eaba249e4a2b&photo_id=" + id + "&format=json&nojsoncallback=1"
                      }).done( function (data) {
                          $("<img src='"+data.sizes.size[1].source +"'>").appendTo("#aagaardliste");
                      });
                  }

                  var aagardUrl ="https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=bc99e15c65aa6b50c011eaba249e4a2b&photoset_id=72157650969693930&format=json&nojsoncallback=1";
                  $.get(aagardUrl). done (function (data) {
                      var pos;
                      for (pos=0; pos<5; pos++) {
                          var photo = data.photoset.photo[pos];
                          addImage(photo.id, photo.title);
                      }
                  });
              };

              billeder();
              function aagard () {
                  function addImage (id, title) {
                      title = title.substring(4, title.length);
                      $.ajax({
                          url:  "https://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=bc99e15c65aa6b50c011eaba249e4a2b&photo_id=" + id + "&format=json&nojsoncallback=1"
                      }).done( function (data) {
                          $("<div><img src='"+data.sizes.size[1].source +"'><br>" + title + "</div>").appendTo("#aagard");
                          $('#aagard').attr('data-id', id);
                      });
                  }

                  var aagardUrl ="https://api.flickr.com/services/rest/?method=flickr.photosets.getPhotos&api_key=bc99e15c65aa6b50c011eaba249e4a2b&photoset_id=72157650969693930&format=json&nojsoncallback=1";
                  $.get(aagardUrl). done (function (data) {
                      var max = data.photoset.photo.length;
                      var pos = Math.floor(Math.random() * (max - 0 +1 ));
                      var photo = data.photoset.photo[pos];
                      addImage(photo.id, photo.title);
                  });
             }
             aagard();
             function kvinde() {
                 $.get("kvinde.php").done( function (data) {
                     $('#kvinde').html(data);
                     $('#kvinde').attr('data-id', data);
                 }).fail( function (data) {
                     console.log("fail:%o", data);
                  });
             }
             kvinde();
             function natmus() {
                 $.get("http://testapi.natmus.dk/v1/Search/?query=(type:asset)").done( function (data) {
                     var max = data.NumberOfResultsReturned;
                     var pos = Math.floor(Math.random() * (max - 0 +1 ));
                     $('#natmus').html('<div><img width=200 src="' + data.Results[pos].assetUrlSizeSmall + '"><br>' + data.Results[pos].description + '</div>');
                });
              }
              natmus();
        </script>
      </div>
    </body>
</html>
