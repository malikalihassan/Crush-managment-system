$(document).ready(function () {

    $(".ItemRowEdit").click(function () {
        ItemRow_onClick($(this));
    });

    $(".btnAddItem").click(function () {
        AddItem_onClick($(this));
    });
});
function ItemRow_onClick(arg) {
    //initializeItemModalDialog();

    // Get the order item details from table
    var row = arg.closest("tr");    // Find the row
    var itemID = row.find(".ItemCol_ItemID").text();
    var itemQuan = row.find(".ItemCol_ItemQuan").text();
    $(".txtProductId").val(itemID);
    $("#droProductId").val(itemID);
    $(".txtorderQuan").val(itemQuan);
    
}

function AddItem_onClick(arg) {
    $(".txtProductId").val("ItemIDValue");
    $(".productname").val("1");
    $(".txtorderQuan").val("1");
}
