'use strict';

jQuery.event.special.touchstart = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchstart", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.touchmove = {
    setup: function( _, ns, handle ) {
        this.addEventListener("touchmove", handle, { passive: !ns.includes("noPreventDefault") });
    }
};
jQuery.event.special.wheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("wheel", handle, { passive: true });
    }
};
jQuery.event.special.mousewheel = {
    setup: function( _, ns, handle ){
        this.addEventListener("mousewheel", handle, { passive: true });
    }
};

/**
 *
 * @param param
 * @param values
 */
const setSession = (param, values) =>
{
	localStorage.setItem(param, JSON.stringify(values));
};

/**
 *
 * @param param
 * @returns {string|boolean}
 */
const getSession = (param) =>
{
	if(localStorage.getItem(param))
		return JSON.parse(localStorage.getItem(param));
	else
		return false;
};

/**
 *
 * @param param
 * @returns {string|boolean}
 */
const hasSession = (param) =>
{
    return !!localStorage.getItem(param);
};

/**
 *
 * @param type
 * @param msg
 */
const showToastr = (type, msg) =>
{
    switch (type)
    {
        case 'info' :
            toastr.info(msg);
            break;
        case 'warning' :
            toastr.warning(msg);
            break;
        case 'error' :
            toastr.error(msg);
            break;
        case 'success' :
            toastr.success(msg);
            break;
    }
};

/**
 *
 * @param icon
 * @param title
 * @param text
 * @param type
 * @returns {boolean|*}
 */
const showSwal = (icon, title, text, type = 'message') =>
{
    if(type == 'message')
    {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
        return true;
    }

    if(type == 'confirm')
    {
        return Swal.fire({
            icon: icon,
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonText: 'Confirmo',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            customClass: {
                confirmButton: "btn btn-primary"
            }
        }).then(result => {
            return !!result.isConfirmed;
        })
    }
};

/**
 * cPage
 */
const cPage = _ =>
{
    var pageNow = window.location.pathname;
    var paths = pageNow.split("/");

    if (paths.length > 1 && paths[1] == 'admin') {
        return paths[2]
    }
    else if (paths.length > 1 && paths[2] == 'admin') {
        return paths[3]
    }
    else {
        return '';
    }
};

/**
 * cUrl
 */
const cUrl = param =>
{
    if(!isEmpty(param)) {
        return `${siteUrl}/${param}`;
    }
    return `${siteUrl}`;
}

/**
 * redirect
 *
 * @var page
 */
const redirect = page =>
{
    window.location.href = page;
    return;
};

/**
 * goBack
 *
 */
const goBack = _ =>
{
    window.history.back();
}

/**
 * isEmpty
 * @var value
 */
const isEmpty = (value) =>
{
    return value === null || value === [] || value === undefined || value === "" || Object.values(value).length === 0 || value.length === 0;
}

/**
 * dateBrToUs
 * @var data
 */
function dateBrToUs(data)
{
    const parts = data.split('/');

    if (parts.length !== 3) {
        return "Formato de data inválido. Use dd/mm/yyyy.";
    }

    const day = parts[0];
    const month = parts[1];
    const year = parts[2];

    if (isNaN(day) || isNaN(month) || isNaN(year)) {
        return "Os elementos de dia, mês e ano devem ser números.";
    }

    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
}

/**
 * dateUsToBr
 * @var data
 */
function dateUsToBr(data)
{
    const parts = data.split('-');

    if (parts.length !== 3) {
        return "Formato de data inválido. Use yyyy-mm-dd.";
    }

    const day = parts[2];
    const month = parts[1];
    const year = parts[0];

    if (isNaN(day) || isNaN(month) || isNaN(year)) {
        return "Os elementos de dia, mês e ano devem ser números.";
    }

    return `${day.padStart(2, '0')}\/${month.padStart(2, '0')}\/${year}`;
}

/**
 * isset
 * @object object
 * @var index
 */
function isset(object, index) {
    return object && typeof object[index] !== 'undefined';
}

/**
 *
 * @param formData
 */
function debugFormData(formData)
{
    const formDataObject = {};
    formData.forEach((value, key) => {
        formDataObject[key] = value;
    });
    console.log('formDataObject: ', formDataObject);
}

/**
 *
 * @param form
 * @returns {{}}
 */
function serializeFormObject(form) {
    const formData = new FormData(form);
    const formObject = {};

    formData.forEach((value, key) => {
        if (formObject[key] !== undefined) {
            if (!Array.isArray(formObject[key])) {
                formObject[key] = [formObject[key]];
            }
            if (value instanceof File) {
                formObject[key].push(value);
            } else {
                formObject[key].push(value);
            }
        } else {
            formObject[key] = value;
        }
    });

    return formObject;
}

/**
 * ajaxLoad
 * @var action
 */
const ajaxLoad = (action) =>
{
    if (action === "open") {
        $(".ajax_load").show().css('display', 'flex');
    }
    if (action === "close") {
        $(".ajax_load").fadeOut();
    }
};

/**
 * boxLoad
 * @var action
 */
const bodyLoad = (action) =>
{
    if (action === "open") {
        $(".body_load").show().css('display', 'flex');
    }
    if (action === "close") {
        $(".body_load").fadeOut();
    }
};

if(logs) console.log('Page: '+cPage());
if(logs) console.log('Url: '+cUrl());
