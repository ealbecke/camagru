
var xhr = new XMLHttpRequest();

var value1 = encodeURIComponent("coucou a vous tous"),
    value2 = encodeURIComponent("Comment allez vous ?");

xhr.open('GET', 'ajax.php?param1='+ value1 +'&param2='+ value2);
xhr.send(null);

xhr.addEventListener('readystatechange', function() {
   xhr.addEventListener('readystatechange', function()
   {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200)
      { 
        // La constante DONE appartient à l'objet XMLHttpRequest, elle n'est pas globale
        //status 200 signifie aue tout s'est bien passé

      }
      else
      {
        alert('Attention au statut : ex.200')
      }
    }
});
});