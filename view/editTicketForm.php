<script type="text/javascript" >

function checkForm() {
  var input = document.editTicketForm.oneLiner;
  if ( input.value.length == 0 )  
    {
      alert("Vous n'avez pas saisi de résumé");
      input.focus();
      return false;
    }
  var selectApp = document.editTicketForm.application;
  input = document.editTicketForm.applicationOther;
  if ( selectApp.value == -1 && input.value.length == 0 )  
    {
      alert("Vous devez saisir le nom de l'application si vous n'en choisissez pas une dans la liste");
      input.focus();
      return false;
    }
  return true;
}

</script>

<form method="POST" name="editTicketForm" 
  ENCTYPE="multipart/form-data" 
  action="editTicketAction.php"
  onSubmit="return checkForm();" >

  <center><br>

  <br>

  <br>

  <table class="tab_cadre">

    <tbody>

      <tr>

        <th colspan="2">Veuillez d&eacute;crire votre
demande d'intervention:</th>

      </tr>

      <tr class="tab_bg_1">

        <td>Application: </td>

        <td>
        <select name="application">
        <?php echo $allApplisAsOptions; ?>
        </select>
        <input size="30" name="applicationOther">
        </td>

      </tr>

      <tr class="tab_bg_1">

        <td>Priorit&eacute;: </td>

        <td>
        <select name="priority">
        <option value="5">Tr&egrave;s urgente</option>
        <option value="4">Urgente</option>
        <option value="3" selected="selected">Moyenne</option>
        <option value="2">Faible</option>
        <option value="1">Tr&egrave;s faible</option>
        </select>

        </td>

      </tr>

      <tr class="tab_bg_1">

        <td>Type: </td>

        <td><input name="type" value="anomalie" checked="checked" type="radio">
Anomalie <input name="type" value="evolution" type="radio"> Demande
d'&eacute;volution
        </td>

      </tr>

      <tr class="tab_bg_1">

        <td>R&eacute;sum&eacute;:</td>

        <td><input size="80" name="oneLiner"></td>

      </tr>

      <tr class="tab_bg_1">

        <td colspan="2" align="left">Description
d&eacute;taill&eacute;e:</td>

      </tr>

      <tr class="tab_bg_1">

        <td colspan="2" align="center"><textarea name="contents" cols="60" rows="14"></textarea></td>

      </tr>

      <tr class="tab_bg_1">

        <td>Pi&egrave;ce-jointe:</td>

        <td><input name="userfile" type="file"></td>

      </tr>

      <tr class="tab_bg_1">

        <td colspan="2" align="right"> <input value="Envoyer" class="submit" type="submit"></td>

      </tr>

    </tbody>
  </table>

  </center>

</form>

