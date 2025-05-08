$(function () {
    let idTab = $('#id_tab').val();
    checkIssetLocalStorage(idTab);


    // choose product by category
    $('body').on('click', '.show-popup_select', function (e) {
        let id = $(this).data('id');
        callModal(id);
    });

    // Sort by type
    $('body').on('change', '#js-sort-holder', function (){
        let id = $(this).data('category');
        let arrAttribute = [];
        let checkbox = $( ".is-pc .attr-checkbox" );
        if(checkMobile()) {
            checkbox = $( ".is-mobile .attr-checkbox" );
        }
        checkbox.each(function( index , item) {
            if ($(item).is(":checked")) {
                arrAttribute.push($(item).val());
            }
        });
        arrAttributeUnique = unique(arrAttribute);
        jsonAttribute = JSON.stringify(arrAttributeUnique);
        let url = $(this).val();
        let sortType = $(this).find(':selected').data('type');
        callModal(id, url, sortType, jsonAttribute);
    });

    // filter product by attribute
    $('body').on('click', '.attr-checkbox', function (){
        let arrAttribute = [];
        let categoryId = $(this).data('category');
        let checkbox = $( ".is-pc .attr-checkbox" );
        if(checkMobile()) {
            checkbox = $( ".is-mobile .attr-checkbox" );
        }
        checkbox.each(function( index , item) {
            if ($(item).is(":checked")) {
                arrAttribute.push($(item).val());
            }
        });

        arrAttributeUnique = unique(arrAttribute);
        jsonAttribute = JSON.stringify(arrAttributeUnique);
        callModal(categoryId, '/filter-product-category', undefined, jsonAttribute);
    });

    // add product to build own PC
    $('body').on('click', '.btn-buy', function () {
        let idTab       = $('#id_tab').val();
        let image       = $(this).data('image');
        let product_id  = $(this).data('id');
        let name        = $(this).data('name');
        let serial      = $(this).data('serial');
        let warranty    = $(this).data('warranty');
        let category_id = $(this).data('category');
        let price       = $(this).data('price');
        let slug        = $(this).data('slug');
        let sort        = $('#js-selected-item-'+category_id).data('sort');
        let urlProd= '/' + slug + '.html';
        let arrayProduct = {};
        let listLocalItem = localStorage.getItem("list_item_build_pc_"+ idTab);
        if (listLocalItem != null) {
            var listItemCookie = jQuery.parseJSON(listLocalItem);
            arrayProduct['total'] = listItemCookie['total'];
            $.each(listItemCookie, function( index, value ) {
                arrayProduct[index] = value;
            });
        }

        arrayProduct['category_id_' +category_id] = {
            "image"       : image,
            "product_id"  : product_id,
            "name"        : name,
            "serial"      : serial,
            "warranty"    : warranty,
            "category_id" : category_id,
            "price"       : price,
            "slug"        : slug,
            "quantity"    : 1,
            "sort"        : sort,
        };

        let html = `<div class="contain-item-drive" data-category_id="${category_id}" data-product_id="${product_id}">
                                <a target="_blank" href="${urlProd}" class="d-img">
                                    <img src="${image}" alt=" ${name}">
                                </a>
                                <div class="d-name">
                                    <a target="_blank" href="${urlProd}">
                                        ${name}
                                    </a>
                                    <br>

                                    Bảo hành: <span style="color: red">${warranty}</span>
                                    <br>
                                    Kho hàng: <span style="color: red">Còn hàng </span> | Mã SP: <span
                                            style="color: red">${serial}</span> <br>

                                </div>
                                <span class="d-price" data-price="${price}">${formatMoney(price)}</span>
                                <i>x</i>
                                <input class="count-p" data-category="${category_id}" type="number" value="1" min="1" max="50">
                                <i>=</i>
                                <span class="sum_price" data-sum-price="${price}">${formatMoney(price)}</span>
                                <span class="btn-action_seclect show-popup_select" data-id="${category_id}">
                                    <i class="fa fa-edit edit-item" aria-hidden="true"></i>
                                </span>
                                <span class="btn-action_seclect delete_select">
                                    <i class="fa fa-trash remove-item" data-category="${category_id}" aria-hidden="true"></i>
                                </span>
                            </div>`;

        $('#js-selected-item-' + category_id).html(html);

        let upDateEstimatePrice= getCurrentTotal();
        arrayProduct['total']           = upDateEstimatePrice;
        saveWorkingBuildPc(arrayProduct)

        $('.total-price-config').html(formatMoney(upDateEstimatePrice));
        closePopup();
    });

    // change quantity
    $('body').on('change', '.count-p', function () {
        let value       = $(this).val();
        let categoryId  = $(this).data('category');
        let price       = $(this).closest('.contain-item-drive').find('.d-price').data('price');
        let total= value * price;

        $(this).closest('.contain-item-drive').find('.sum_price').attr('data-sum-price', total).html(formatMoney(total));
        let upDateEstimatePrice = getCurrentTotal();
        $('.total-price-config').html(formatMoney(upDateEstimatePrice));

        arrayProduct = getAllData();

        arrayProduct['total']           = upDateEstimatePrice;
        arrayProduct['category_id_' +categoryId]['quantity'] = parseInt(value);
        saveWorkingBuildPc(arrayProduct)
    });

    // remove item of build list
    $('body').on('click', '.remove-item', function () {
        let updatePrice = 0;
        let categoryId = $(this).data('category');
        deleteSelectProd(categoryId);

        arrayProduct = getAllData();

        if (arrayProduct.hasOwnProperty('category_id_' +categoryId)) {
            delete arrayProduct['category_id_' +categoryId]
        }

        let upDateEstimatePrice = getCurrentTotal();
        arrayProduct['total'] = upDateEstimatePrice;
        $('.total-price-config').html(formatMoney(upDateEstimatePrice));
        saveWorkingBuildPc(arrayProduct)
    });

    // renew list build item
    $('#rebuild-product').on('click', function (){
        Swal.fire({
            title: 'LÀM MỚI',
            text: "Cảnh báo: Toàn bộ linh kiện của bộ PC hiện tại sẽ bị xoá đi",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Xác nhận'
        }).then((result) => {
            if (result.isConfirmed) {
                let idTab = $('#id_tab').val();
                $('.js-item-row').each(function (index, item) {
                    $(item).html('')
                });

                localStorage.setItem("list_item_build_pc_"+idTab, []);
                localStorage.removeItem("list_item_build_pc_"+idTab);
                $('.total-price-config').html(formatMoney(0));
            }
        })
    });

    // view and print list
    $('#view_and_print').on('click', function (){
        $.ajax({
            url    : '/view-and-print',
            type   : 'GET',
            data   : ({
                id: id,
                sort: sortType,
                array_attribute: dataAttribute
            }),
            success: function (result) {

            },
            error  : function (error) {

            }
        });
    });

    $('#view_and_print_form').on('submit',function (e){
        let idInput = 'view_and_print';
        if (!checkEmptyData(idInput)) {
            e.preventDefault();
            return;
        }
    });

    $('#excel_download_form').on('submit',function (e){
        let idInput = 'excel_download';
        if (!checkEmptyData(idInput)) {
            e.preventDefault();
            return;
        }
    });


    $('#add_to_cart_build_pc_form').on('submit',function (e){
        let idInput = 'add_to_cart_buildpc_input';
        if (!checkEmptyData(idInput)) {
            e.preventDefault();
            return;
        }
    });


});

function closePopup() {
    $('.mask-popup').removeClass('active');
    $('.popup-select').removeClass('active');
    $('.js-modal-popup').html();
    $('body').css('overflow', 'auto');
}

function formatMoney(money) {
    return new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'}).format(money);
}

function callModal(id, url = '/get-modal-buildpc', sortType = 0, dataAttribute = []) {
    $.ajax({
        url    : url,
        type   : 'GET',
        data   : ({
            id: id,
            sort: sortType,
            array_attribute: dataAttribute,
            is_call_modal: true
        }),
        success: function (result) {
            $('#js-modal-popup').html(result);
            $('.mask-popup').addClass('active');
            $('#table-product-dbtable').DataTable({
                "ordering": false,
                "bLengthChange": false,
                "pagingType": "numbers",
                "pageLength": 10,
                "scrollCollapse": true,
                "responsive": true,
                "scrollY": '60vh',
                "language": {
                    searchPlaceholder: "Bạn cần tìm linh kiện gì",
                    search: "Tìm kiếm:",
                    lengthMenu: "Display -- records per page",
                    zeroRecords: "Không tìm thấy sản phẩm nào",
                    infoEmpty: "",
                    info: "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ sản phẩm",
                    infoFiltered: ""
                }
            });
        },
        error  : function (error) {

        }
    });
}

function deleteSelectProd(category_id) {
    $('#js-selected-item-' + category_id).html('');
}

function getCurrentTotal(){
    let currentEstimatePrice = 0;
    $('.contain-item-drive').each(function (idex, item) {
        let sumPriceItem    = parseInt($(item).find('.sum_price').attr('data-sum-price'));
        currentEstimatePrice += sumPriceItem;
    });

    return currentEstimatePrice;
}

function saveWorkingBuildPc(arrayProduct) {
    let idTab = $('#id_tab').val();
    let currentProduct =  JSON.stringify(arrayProduct);
    $('#view_and_print').val(currentProduct);
    $('#excel_download').val(currentProduct);
    $('#generate_image').val(currentProduct);
    $('#add_to_cart_buildpc_input').val(currentProduct);

    localStorage.setItem("list_item_build_pc_"+idTab, currentProduct);
}

function checkEmptyData(idInput) {
    let idTab = $('#id_tab').val();
    var dataProd = localStorage.getItem("list_item_build_pc_"+idTab)
    if (dataProd != null) {
        $('#'+idInput).val(dataProd);
        return true;
    }
    else if (dataProd == null || typeof dataProd == "undefined" || dataProd.length === 0 || !dataProd ) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Bạn chưa chọn sản phẩm nào!',
        })
        return false;
    }
    return true;
}

function checkIssetLocalStorage(id = 1) {
    var arrayProduct = {};
    let listLocalItem = localStorage.getItem("list_item_build_pc_"+ id);
    if (listLocalItem != null) {
        var listItemCookie = jQuery.parseJSON(listLocalItem);
        arrayProduct['total'] = listItemCookie['total'];
        $.each(listItemCookie, function( index, value ) {
            arrayProduct[index] = value;
        });
    }
    if(listLocalItem == null || typeof listLocalItem == "undefined" || listLocalItem.length === 0 || !listLocalItem) {
        return;
    }

    $('#view_and_print').val(listLocalItem);
    $('#excel_download').val(listLocalItem);
    $('#add_to_cart_buildpc_input').val(listLocalItem);
    $.ajax({
        url    : '/check-local-storage',
        type   : 'GET',
        data   : ({
            data: listLocalItem
        }),
        success: function (result) {

            $.each(result.view, function( cateId, strHtml ) {
                $('#js-selected-item-'+cateId).html(strHtml);
            });

            $('.total-price-config').html(formatMoney(result.total));
        },
        error  : function (error) {

        }
    });
}

function unique(list) {
    var result = [];
    $.each(list, function(i, e) {
        if ($.inArray(e, result) == -1) result.push(e);
    });
    return result;
}

function checkMobile() {
    var isMobile = false; //initiate as false
// device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
        isMobile = true;
    }

    return isMobile;
}

function changeTab(id) {
    $('#id_tab').val(id);
    $('.tab_build_pc').removeClass('active');
    $('#tab_'+id).addClass('active');
    $('#view_and_print').val('');
    $('#excel_download').val('');
    $('#add_to_cart_buildpc_input').val('');
    $('.js-item-row').each(function (index, item) {
        $(item).html('')
    });

    checkIssetLocalStorage(id)
}

function getAllData() {
    let idTab = $('#id_tab').val();
    let arrayProduct = localStorage.getItem("list_item_build_pc_"+idTab)
    arrayProduct = jQuery.parseJSON(arrayProduct);
    return arrayProduct;
}