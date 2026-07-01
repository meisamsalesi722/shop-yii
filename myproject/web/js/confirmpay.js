$(".address-item").click(function() {
    $(".address-item").removeClass("address-item-active");
    $(this).addClass("address-item-active");
    $(".address-item").children(0).children(0).removeClass("d-block");
    $(this).children(0).children(0).addClass("d-block");
});