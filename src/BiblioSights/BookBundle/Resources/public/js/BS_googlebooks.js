/*
 * Adición del enlace para añadir varios autores
 * @var collectionHolfer: selecciona el campo que muestra el campo del fomulario
 * @var addAuthorLink: HTML del enlace
 * @var newLinkli 
 */
var collectionHolder = $('ul.authors');
var $addAuthorLink = $('<a href="#" class="add_author_link button tiny secondary">Añade más autores</a>');
var $newLinkLi = $('<p></p>').append($addAuthorLink);
collectionHolder.append($newLinkLi);
collectionHolder.data('index', collectionHolder.find(':input').length);
$addAuthorLink.on('click', function (e) {
    e.preventDefault();
    addTagForm(collectionHolder, $newLinkLi);
});
collectionHolder.find('li').each(function () {
        addTagFormDeleteLink($(this));
});

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
                    volumeObj(index, value, GoogleDiv);
                });                             
            });
        }
    }); 
});

function volumeObj(index, value, GoogleDiv) {
    var newdiv = document.createElement('div');
    newdiv.id = "googlebooks_"+index;
    newdiv.setAttribute("data-bstitle",value["volumeInfo"]["title"]);
    newdiv.setAttribute("data-bspublishedDate",value["volumeInfo"]["publishedDate"]);


    var authors = value["volumeInfo"]["authors"];
    var authorsString = "";
    $.each(authors, function (index, value) {
        authorsString += value+"__";
    });
    newdiv.setAttribute("data-bsauthor", authorsString); 

    var ISBNs = value["volumeInfo"]["industryIdentifiers"];
    $.each(ISBNs, function (index, value) {
        newdiv.setAttribute("data-bs"+value["type"], value["identifier"]);
    });                   

    newdiv.innerHTML = JSON.stringify(value["volumeInfo"]["title"]);
    GoogleDiv.append(newdiv);
    $("#googlebooks_"+index).on('click', function (event) {
       // Eliminamos todos los campos author menos el primero
       $(".addAuthor").remove();
        
       var titleField = $('#Book_ISBNs_0_Title');
       var isbn13Field = $('#Book_ISBNs_0_ISBN13');
       var isbn10Field = $('#Book_ISBNs_0_ISBN10');
       var editionyearField = $('#Book_ISBNs_0_EditionYear');
       
       // Process string to get an array of authors
       var bsauthors = $(this).attr('data-bsauthor');
       bsauthors = bsauthors.substring(0, bsauthors.length-2);
       var authorsArray = bsauthors.split("__");
       alert(authorsArray);
       
       $.each(authorsArray, function (index, value) {
           if (index === 0) {
               $('#Book_authors_'+index+"_name").val(value);
           } else {
               addTagForm(collectionHolder, $newLinkLi);
               $('#Book_authors_'+index+"_name").val(value);
           }
       });       

       titleField.val($(this).attr('data-bstitle'));           
       isbn13Field.val($(this).attr('data-bsisbn_13'));           
       isbn10Field.val($(this).attr('data-bsisbn_10'));           
       editionyearField.val($(this).attr('data-bspublisheddate').substring(0,4));           
    });
};  

/*
 * @Function addTagForm
 */

function addTagForm(collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');

    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<p class="addAuthor"></p>').append(newForm);
    $newLinkLi.before($newFormLi);
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink ($tagFormLi) {
    var $removeFormA = $('<a href="#" class="deleteAuthor button tiny round secondary">X</a>');
    $tagFormLi.append($removeFormA);
    $removeFormA.on('click', function (e) {
        e.preventDefault();
        $tagFormLi.remove();
    });
}