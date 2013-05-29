$('#googlebook').on('click', function (event) {
    event.preventDefault();
    var title = $('#Book_ISBNs_0_Title').val();
    var GoogleDiv = $('#googlebooks');

    $.ajax({
        url: "https://www.googleapis.com/books/v1/volumes?q="+title+"&maxResults=3&fields=items/volumeInfo(title, publishedDate, authors, industryIdentifiers)",
        success: function (data) {
            GoogleDiv.empty();
            $.each(data, function (index, value) {
                var volume = value;
                
                $.each(volume, function (index, value) {
                    volumeObj(index, value);
                });                             
            });
        }
    });
    
    function volumeObj(index, value) {
        var newdiv = document.createElement('div');
        newdiv.id = "googlebooks_"+index;
        newdiv.setAttribute("data-bstitle",value["volumeInfo"]["title"]);
        newdiv.setAttribute("data-bspublishedDate",value["volumeInfo"]["publishedDate"]);


        var authors = value["volumeInfo"]["authors"];
        $.each(authors, function (index, value) {
            newdiv.setAttribute("data-bsauthor"+index, value); 
        });

        var ISBNs = value["volumeInfo"]["industryIdentifiers"];
        $.each(ISBNs, function (index, value) {
            newdiv.setAttribute("data-bs"+value["type"], value["identifier"]);
        });                   

        newdiv.innerHTML = JSON.stringify(value["volumeInfo"]["title"]);
        GoogleDiv.append(newdiv);
        $("#googlebooks_"+index).on('click', function (event) {
           alert("clicked"+index); 
           var titleField = $('#Book_ISBNs_0_Title');
           var isbn13Field = $('#Book_ISBNs_0_ISBN13');
           var isbn10Field = $('#Book_ISBNs_0_ISBN10');
           var editionyearField = $('#Book_ISBNs_0_EditionYear');
           
           titleField.val($(this).attr('data-bstitle'));           
           isbn13Field.val($(this).attr('data-bsisbn_13'));           
           isbn10Field.val($(this).attr('data-bsisbn_10'));           
           editionyearField.val($(this).attr('data-bspublisheddate').substring(0,4));           
        });
    };    
});