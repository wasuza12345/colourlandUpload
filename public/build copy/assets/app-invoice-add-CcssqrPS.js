(function(){const l=document.querySelectorAll(".invoice-item-price"),o=document.querySelectorAll(".invoice-item-qty"),a=document.querySelectorAll(".date-picker"),c=document.querySelector(".invoice-date"),i=document.querySelector(".due-date");l&&l.forEach(function(n){new Cleave(n,{delimiter:"",numeral:!0})}),o&&o.forEach(function(n){new Cleave(n,{delimiter:"",numeral:!0})}),a&&a.forEach(function(n){n.flatpickr({monthSelectorType:"static"})}),c&&c.flatpickr({monthSelectorType:"static"}),i&&i.flatpickr({monthSelectorType:"static"})})();$(function(){var l=$(".btn-apply-changes"),o,a,c,i,n,r,p=$(".source-item"),u={"App Design":"Designed UI kit & app pages.","App Customization":"Customization & Bug Fixes.","ABC Template":"Bootstrap 4 admin template.","App Development":"Native App Development."};$(document).on("click",".tax-select",function(e){e.stopPropagation()});function s(e,t){e.closest(".repeater-wrapper").find(t).text(e.val())}l.length&&$(document).on("click",".btn-apply-changes",function(e){var t=$(this);n=t.closest(".dropdown-menu").find("#taxInput1"),r=t.closest(".dropdown-menu").find("#taxInput2"),i=t.closest(".dropdown-menu").find("#discountInput"),a=t.closest(".repeater-wrapper").find(".tax-1"),c=t.closest(".repeater-wrapper").find(".tax-2"),o=$(".discount"),n.val()!==null&&s(n,a),r.val()!==null&&s(r,c),i.val().length&&t.closest(".repeater-wrapper").find(o).text(i.val()+"%")}),p.length&&(p.on("submit",function(e){e.preventDefault()}),p.repeater({show:function(){$(this).slideDown(),[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function(t){return new bootstrap.Tooltip(t)})},hide:function(e){$(this).slideUp()}})),$(document).on("change",".item-details",function(){var e=$(this),t=u[e.val()];e.next("textarea").length?e.next("textarea").val(t):e.after('<textarea class="form-control" rows="2">'+t+"</textarea>")})});
