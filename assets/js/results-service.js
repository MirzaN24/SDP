var ResultsService = {

    list: function () {
        $.ajax({
            url: "rest/user_results/" + user_id,
            type: "GET",
            beforeSend: function(xhr){
              xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (data) {
                $("#table_of_results").html("");
                var html = "";
                for (let i = 0; i < data.length; i++) {
                    html += `<tr>
                    <th scope="col">No</th>
                    <th scope="col">USERNAME</th>
                    <th scope="col">CONTENT</th>
                    <th scope="col">SENTIMENT</th>
                    <th scope="col">MORE</th>
                  </tr>
                    <tr>
                        <th>`+ data[i].user_id + ` </th>
                        <th>`+ data[i].username + ` </th>
                        <th>`+ data[i].content + ` </th>
                        <th>`+ data[i].sentiment + ` </th>
                        <td style="text-align: center;">
                              <button type="button" class="btn btn-danger membership-button" onclick="MembershipService.delete(`+ data[i].user_id + `)"></button>
                        </td>
            </tr>`;

                }
                $("#table_of_results").html(html);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    },

    delete: function (id) {
        $.ajax({
            url: 'rest/user_membership/' + id,
            type: 'DELETE',
            beforeSend: function(xhr){
            xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
            },
            success: function (result) {
                $("#membership-table-full-list").html('<div class="spinner-border" role="status"><span class="sr-only"></span></div>');
                MembershipService.list();
                toastr.success("Deleted!");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                toastr.error(XMLHttpRequest.responseJSON.message);
            }
        });
    }
}