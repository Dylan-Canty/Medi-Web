<div class="modal" id="edit-patient">
        <div class=''>
            <button class="btn-small right-align modal-close float-right green"><i class="material-icons">close</i></button>
        </div>
        <form action="php/handler.php" method="POST" onsubmit="" class='container row'>
            <h4 class="center-align col s12">Edit Patient</h4>
            <input type="hidden" id='patient-id' name='id' value=''>
            <div class="input-field col s12">
                <label for="fname" id='fname-label'>First Name</label>
                <input type="text" id='fname' name='fname' required>
            </div>
            <div class="input-field col s12">
                <label for="lname" id='lname-label'>Last Name</label>
                <input type="text" id='lname' name='lname' required>
            </div>
            <div class="input-field col s12">
                <label for="email" id='email-label'>Email</label>
                <input type="email" id='email' name='email' required>
            </div>
            <div class="input-field col s12">
                <label for="phone" id='phone-label'>Phone</label>
                <input type="text" id='phone' name='phone' required>
            </div>
            <!-- <div class="col s12 divider"></div>
            <div class="input-field col s12">
                <span>Heart Risk :</span>
                <input type="number" id='heart' name='heart' required>
            </div>
            <div class="input-field col s12">
                <span>Cancer Risk :</span>
                <input type="number" id='cancer' name='cancer' required>
            </div>
            <div class="input-field col s12">
                <span>Diabetes Risk :</span>
                <input type="number" id='diabetes' name='diabetes' required>
            </div> -->
            <div class="input-field center-align col s12">
                <button type="submit" name='editInfo' class='btn-small light-green darken-2 white-text'>SUBMIT</button>
            </div>
            <p id="success" class="col s12 green-text"></p>
        </form>
    </div>