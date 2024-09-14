(function(){let d;isDarkStyle?(config.colors_dark.cardColor,d=config.colors_dark.textMuted,config.colors_dark.headingColor):(config.colors.cardColor,d=config.colors.textMuted,config.colors.headingColor);const c=document.querySelector("#reviewsChart"),f={chart:{height:160,width:190,type:"bar",toolbar:{show:!1}},plotOptions:{bar:{barHeight:"75%",columnWidth:"40%",startingShape:"rounded",endingShape:"rounded",borderRadius:5,distributed:!0}},grid:{show:!1,padding:{top:-25,bottom:-12}},colors:[config.colors_label.success,config.colors_label.success,config.colors_label.success,config.colors_label.success,config.colors.success,config.colors_label.success,config.colors_label.success],dataLabels:{enabled:!1},series:[{data:[20,40,60,80,100,80,60]}],legend:{show:!1},xaxis:{categories:["M","T","W","T","F","S","S"],axisBorder:{show:!1},axisTicks:{show:!1},labels:{style:{colors:d,fontSize:"13px"}}},yaxis:{labels:{show:!1}},responsive:[{breakpoint:0,options:{chart:{width:"100%"},plotOptions:{bar:{columnWidth:"40%"}}}},{breakpoint:1440,options:{chart:{height:150,width:190,toolbar:{show:!1}},plotOptions:{bar:{borderRadius:6,columnWidth:"40%"}}}},{breakpoint:1400,options:{plotOptions:{bar:{borderRadius:6,columnWidth:"40%"}}}},{breakpoint:1200,options:{chart:{height:130,width:190,toolbar:{show:!1}},plotOptions:{bar:{borderRadius:6,columnWidth:"40%"}}}},{breakpoint:992,chart:{height:150,width:190,toolbar:{show:!1}},options:{plotOptions:{bar:{borderRadius:5,columnWidth:"40%"}}}},{breakpoint:883,options:{plotOptions:{bar:{borderRadius:5,columnWidth:"40%"}}}},{breakpoint:768,options:{chart:{height:150,width:190,toolbar:{show:!1}},plotOptions:{bar:{borderRadius:4,columnWidth:"40%"}}}},{breakpoint:576,options:{chart:{width:"100%",height:"200",type:"bar"},plotOptions:{bar:{borderRadius:6,columnWidth:"30% "}}}},{breakpoint:420,options:{plotOptions:{chart:{width:"100%",height:"200",type:"bar"},bar:{borderRadius:3,columnWidth:"30%"}}}}]};typeof c!==void 0&&c!==null&&new ApexCharts(c,f).render()})();$(function(){let d,c,f;isDarkStyle?(d=config.colors_dark.borderColor,c=config.colors_dark.bodyBg,f=config.colors_dark.headingColor):(d=config.colors.borderColor,c=config.colors.bodyBg,f=config.colors.headingColor);var v=$(".datatables-review"),g=baseUrl+"app/ecommerce/customer/details/overview",b={Pending:{title:"Pending",class:"bg-label-warning"},Published:{title:"Published",class:"bg-label-success"}};if(v.length)var x=v.DataTable({ajax:assetsPath+"json/app-ecommerce-reviews.json",columns:[{data:""},{data:"id"},{data:"product"},{data:"reviewer"},{data:"review"},{data:"date"},{data:"status"},{data:" "}],columnDefs:[{className:"control",searchable:!1,orderable:!1,responsivePriority:2,targets:0,render:function(a,o,r,s){return""}},{targets:1,orderable:!1,searchable:!1,responsivePriority:3,checkboxes:!0,render:function(){return'<input type="checkbox" class="dt-checkboxes form-check-input">'},checkboxes:{selectAllRender:'<input type="checkbox" class="form-check-input">'}},{targets:2,render:function(a,o,r,s){var e=r.product,n=r.company_name,t=r.id,l=r.product_image;if(l)var p='<img src="'+assetsPath+"img/ecommerce-images/"+l+'" alt="Product-'+t+'" class="rounded-2">';else{var m=Math.floor(Math.random()*6),h=["success","danger","warning","info","dark","primary","secondary"],i=h[m],e=r.product,u=e.match(/\b\w/g)||[];u=((u.shift()||"")+(u.pop()||"")).toUpperCase(),p='<span class="avatar-initial rounded bg-label-'+i+'">'+u+"</span>"}var w='<div class="d-flex justify-content-start align-items-center customer-name"><div class="avatar-wrapper"><div class="avatar me-4 rounded-2 bg-label-secondary">'+p+'</div></div><div class="d-flex flex-column"><span class="fw-medium text-nowrap text-heading">'+e+"</span></a><small>"+n+"</small></div></div>";return w}},{targets:3,responsivePriority:1,render:function(a,o,r,s){var e=r.reviewer,n=r.email,t=r.avatar;if(t)var l='<img src="'+assetsPath+"img/avatars/"+t+'" alt="Avatar" class="rounded-circle">';else{var p=Math.floor(Math.random()*6),m=["success","danger","warning","info","dark","primary","secondary"],h=m[p],e=r.reviewer,i=e.match(/\b\w/g)||[];i=((i.shift()||"")+(i.pop()||"")).toUpperCase(),l='<span class="avatar-initial rounded-circle bg-label-'+h+'">'+i+"</span>"}var u='<div class="d-flex justify-content-start align-items-center customer-name"><div class="avatar-wrapper"><div class="avatar avatar-sm me-4">'+l+'</div></div><div class="d-flex flex-column"><a href="'+g+'"><span class="fw-medium">'+e+'</span></a><small class="text-nowrap">'+n+"</small></div></div>";return u}},{targets:4,responsivePriority:2,sortable:!1,render:function(a,o,r,s){var e=r.review,n=r.head,t=r.para,l=$('<div class="read-only-ratings ps-0 mb-1"></div>');function p(i){return typeof i!="string"||i.length===0?i:i.charAt(0).toUpperCase()+i.slice(1)}var m=p(n);l.rateYo({rating:e,rtl:isRtl,readOnly:!0,starWidth:"24px",spacing:"3px",starSvg:'<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-star-filled" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" stroke-width="0" /></svg>'});var h="<div>"+l.prop("outerHTML")+'<p class="h6 mb-1 text-truncate">'+m+'</p><small class="text-break pe-3">'+t+"</small></div>";return h}},{targets:5,render:function(a,o,r,s){var e=new Date(r.date),n=e.toLocaleDateString("en-US",{month:"short",day:"numeric",year:"numeric"});return'<span class="text-nowrap">'+n+"</span>"}},{targets:6,render:function(a,o,r,s){var e=r.status;return'<span class="badge '+b[e].class+'" text-capitalize>'+b[e].title+"</span>"}},{targets:-1,title:"Actions",searchable:!1,orderable:!1,render:function(a,o,r,s){return'<div class="text-xxl-center"><div class="dropdown"><a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-md"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="javascript:;" class="dropdown-item">Download</a><a href="javascript:;" class="dropdown-item">Edit</a><a href="javascript:;" class="dropdown-item">Duplicate</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>'}}],order:[[2,"asc"]],dom:'<"card-header d-flex align-items-md-center align-items-start py-0 flex-wrap flex-md-row flex-column"<"me-5 ms-n4"f><"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-start align-items-sm-center justify-content-md-end pt-0 gap-sm-2 gap-6 flex-wrap flex-sm-row flex-column mb-6 mb-sm-0"l<"review_filter"> <"mx-0 me-md-n3 mt-sm-0"B>>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',language:{sLengthMenu:"_MENU_",search:"",searchPlaceholder:"Search Review",paginate:{next:'<i class="ti ti-chevron-right ti-sm"></i>',previous:'<i class="ti ti-chevron-left ti-sm"></i>'}},buttons:[{extend:"collection",className:"btn btn-label-secondary dropdown-toggle ms-sm-2 me-3 waves-effect waves-light",text:'<i class="ti ti-upload ti-xs me-2"></i>Export',buttons:[{extend:"print",text:'<i class="ti ti-printer me-2" ></i>Print',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(a,o,r){if(a.length<=0)return a;var s=$.parseHTML(a),e="";return $.each(s,function(n,t){t.classList!==void 0&&t.classList.contains("customer-name")?e=e+t.lastChild.firstChild.textContent:t.innerText===void 0?e=e+t.textContent:e=e+t.innerText}),e}}},customize:function(a){$(a.document.body).css("color",f).css("border-color",d).css("background-color",c),$(a.document.body).find("table").addClass("compact").css("color","inherit").css("border-color","inherit").css("background-color","inherit")}},{extend:"csv",text:'<i class="ti ti-file me-2" ></i>Csv',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(a,o,r){if(a.length<=0)return a;var s=$.parseHTML(a),e="";return $.each(s,function(n,t){t.classList!==void 0&&t.classList.contains("customer-name")?e=e+t.lastChild.firstChild.textContent:t.innerText===void 0?e=e+t.textContent:e=e+t.innerText}),e}}}},{extend:"excel",text:'<i class="ti ti-file-export me-2"></i>Excel',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(a,o,r){if(a.length<=0)return a;var s=$.parseHTML(a),e="";return $.each(s,function(n,t){t.classList!==void 0&&t.classList.contains("customer-name")?e=e+t.lastChild.firstChild.textContent:t.innerText===void 0?e=e+t.textContent:e=e+t.innerText}),e}}}},{extend:"pdf",text:'<i class="ti ti-file-text me-2"></i>Pdf',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(a,o,r){if(a.length<=0)return a;var s=$.parseHTML(a),e="";return $.each(s,function(n,t){t.classList!==void 0&&t.classList.contains("customer-name")?e=e+t.lastChild.firstChild.textContent:t.innerText===void 0?e=e+t.textContent:e=e+t.innerText}),e}}}},{extend:"copy",text:'<i class="ti ti-copy me-2"></i>Copy',className:"dropdown-item",exportOptions:{columns:[1,2,3,4,5,6],format:{body:function(a,o,r){if(a.length<=0)return a;var s=$.parseHTML(a),e="";return $.each(s,function(n,t){t.classList!==void 0&&t.classList.contains("customer-name")?e=e+t.lastChild.firstChild.textContent:t.innerText===void 0?e=e+t.textContent:e=e+t.innerText}),e}}}}]}],responsive:{details:{display:$.fn.dataTable.Responsive.display.modal({header:function(a){var o=a.data();return"Details of "+o.customer}}),type:"column",renderer:function(a,o,r){var s=$.map(r,function(e,n){return e.title!==""?'<tr data-dt-row="'+e.rowIndex+'" data-dt-column="'+e.columnIndex+'"><td>'+e.title+":</td> <td>"+e.data+"</td></tr>":""}).join("");return s?$('<table class="table"/><tbody />').append(s):!1}}},initComplete:function(){this.api().columns(6).every(function(){var a=this,o=$('<select id="Review" class="form-select"><option value=""> All </option></select>').appendTo(".review_filter").on("change",function(){var r=$.fn.dataTable.util.escapeRegex($(this).val());a.search(r?"^"+r+"$":"",!0,!1).draw()});a.data().unique().sort().each(function(r,s){o.append('<option value="'+r+'" class="text-capitalize">'+r+"</option>")})})}});$(".datatables-review tbody").on("click",".delete-record",function(){x.row($(this).parents("tr")).remove().draw()}),setTimeout(()=>{$(".dataTables_filter .form-control").removeClass("form-control-sm"),$(".dataTables_filter").addClass("mb-0 mb-md-6"),$(".dataTables_length .form-select").removeClass("form-select-sm"),$(".dataTables_length").addClass("ms-n2 me-2 me-sm-0 mb-0 mb-sm-6")},300)});
