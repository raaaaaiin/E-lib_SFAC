<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background-color: rgb(113 2 2);">
        <h4 class="modal-title" style="color: white!important;">SHAN ELIB QR AUTOMATION</h4>
          <button style="color: white!important;" type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div><br>
        <div id="demo" style="display: flex!important;
    justify-content: center;">
        </div>
        <div class="modal-body">
        <p style="font-size:24px;margin:0!important;">Book Title : <span style="font-size:24px;">{{isset($book_obj) ? $book_obj->title : "N/A"}}</span></p>
        <p style="font-size:18px;margin:0!important;">Expected Borrowing Date : <span id="iss" style="font-size:18px;"></span> </script></p>
        <p style="font-size:18px;margin:0!important;">Expected Returning Date : <span id="ret" style="font-size:18px;"></span> </script></p>
          <p style="color:red;font-size:12px;margin:0!important;">*Save or Screenshot this image.<br>Proceed on Library and get QR scanned<br>Claim book on the librarian</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
