<?php //debug($currentDateTime); ?>
<?php $time=$currentDateTime->i18nFormat('yyyy-MM-dd HH:mm:ss'); ?>
<?php if (isset($relationItem)): ?>
	<script>
	var relationItem = '<?php echo json_encode($relationItem); ?>';
	relationItem = JSON.parse(relationItem);
	</script>

<?php endif ?>
<script>
	moment.locale('es-ES');
	$('#item-type_item_id').change(function(){
		val=$(this).val();
		if (val==1) {
			$('.fecha_reunion, .fecha_vencimiento').hide();
			$('.fecha_reunion').show();
		}else if (val==2) {
			$('.fecha_reunion, .fecha_vencimiento').hide();
			$('.fecha_vencimiento').show();
		}else if (val==3) {
			$('.fecha_reunion, .fecha_vencimiento').hide();
		}
	});
	var socket = io('<?php echo $urlSiteSocket; ?>');

	CKEDITOR.config.toolbar_MA=[ ['Link','Unlink','Bold','Italic','Underline','-','NumberedList','BulletedList'] ];
	  editor=CKEDITOR.replace( 'description' ); 

	  var isCancel=0;

	  $(document).on('click', '.descriptionItem #addC', function(e)
	  	{
	  		e.preventDefault();
	  		updateIte();
	  	});
	  $(document).on('click', '.descriptionItem #cancelC', function(e)
	  	{
	  		e.preventDefault();
	  		$('#itemSingle .descriptionItem, .descriptionItem').find('div.card-text, div.contentText').show();
	  		$('#itemSingle .descriptionItem, .descriptionItem').find('.holder_item2').hide();
	  		$('.descriptionItem .itemButton').hide();

	  		prevContent=$('#itemSingle .descriptionItem div.card-text').html();

	  		editor.setData(prevContent);
	  		isCancel=1;
	  		return false;
	  	});

	  editor.on("blur", function(){
	  	if (isCancel==0) {
	  		updateIte();
	  	}
	  	if (isCancel==1) {
	  		isCancel=0;
	  	}
	  });

	  function updateIte(){
	  	//alert('sdfgs');
	  	valueC=editor.getData();
	  	item_id=$("#actionComment textarea").attr('data-itemid');
	  	//update
	  	if(valuedescription!=valueC && valueC!=''){
	  	    $('#itemSingle .descriptionItem, .descriptionItem').find('div.card-tex, div.contentText').html(valueC);
	  	    updateSingle(item_id, 'description', valueC);
	  	    valuedescription=valueC;
	  	};
	  	///alert('sdfgs');
	  	$('#itemSingle .descriptionItem, .descriptionItem').find('div.card-text, div.contentText').show();
	  	$('#itemSingle .descriptionItem, .descriptionItem').find('.holder_item2').hide();
	  	$('.descriptionItem .itemButton').hide();
	  	//alert('sdfgs');
	  }
/*fin description editor*/
		var fileobj;
		function upload_fileover(){
			$('body .backDrop').show();
		}
		function upload_fileout(){
			$('body .backDrop').hide();
		}
		function upload_file(e) {
		  e.preventDefault();
		  fileobj = e.dataTransfer.files;
		  ajax_file_upload(fileobj);
		}

		function file_explorer() {
		  document.getElementById('selectfile').click();
		  document.getElementById('selectfile').onchange = function() {
		      fileobj = document.getElementById('selectfile').files;
		      ajax_file_upload(fileobj);
		  };
		}

		function upload_fileI(e) {
		  e.preventDefault();
		  fileobj = e.dataTransfer.files;
		  $('body .backDrop').hide();
		}

		function file_explorerI() {
		  document.getElementById('selectfile').click();
		  document.getElementById('selectfile').onchange = function() {
		      fileobj = document.getElementById('selectfile').files;
		  };
		}


		function ajax_file_upload(file_obj) {
		  if(file_obj != undefined) {
		  	itemId=$("#actionComment textarea").attr('data-itemid');
		  	//alert(itemId);
		      var form_data = new FormData();
		      form_data.append('item_id', itemId);
		      //console.log(file_obj.length);
		      $.each(file_obj, function( index, value ) {
		      	form_data.append('file[]', value);
		      });
		      //form_data.append('file[]', file_obj[0]);
		      $('body .backDrop').hide();
		      //alert('yeah');
		      
		      var jc=$.dialog({
		          title: 'Subiendo archivos',
		          closeIcon: false,
		          content: '<div id="progressFile" class="progress md-progress" style="height: 20px"><div class="progress-bar" role="progressbar" style="width: 25%; height: 20px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div></div>',
		      });
		      $.ajax({
		          type: 'POST',
		          url: '/addFiles/',
		          contentType: false,
		          processData: false,
		          data: form_data,
		          success:function(response) {
		              //console.log(response);
		              socket.emit('attach files', response);
		              $('#selectfile').val('');
		              jc.close();
		          },
					xhr: function () {
						var xhr = new XMLHttpRequest();
						xhr.upload.onprogress = function (e) {
						var percent = '0';
						var percentage = '0%';
							if (e.lengthComputable) {
							  percent = Math.round((e.loaded / e.total) * 100);
							  percentage = percent + '%';
							  $('#progressFile .progress-bar').css('width',percentage);
							  $('#progressFile .progress-bar').attr('aria-valuenow',percent);
							  $('#progressFile .progress-bar').text(percentage);
							}
						};
						return xhr;
					},
		      });
		  }
		}

		$(document).on('click','#addComment', function(e){
			e.preventDefault();
		  	editorComments=CKEDITOR.inline( 'addComment',
		  	            {   toolbar:'MA'    }
		  	         );
		  	setTimeout(function(){ editorComments.focus(); 
		  		
		  	 }, 150);
		  	editorComments.on("blur", function(){
		  		CKEDITOR.instances['addComment'].destroy(true);
		  		$('.zonCommentButton').hide();
		  	});
		  	$('.zonCommentButton').show();
		});

	  $('#showEarlierComments').click(function(){
	  	$(".listComments li.listComment").show();
	  	$(this).hide();
	  });

	  $('#modalItem').on('shown.bs.modal', function (e) {

	  	


	    contentTextHeight=$('.contentText').height();
	    if (contentTextHeight>200) {
	    	$('.contentText').css('height',200);
	    	$('#viewMore').show();
	    }else{
	    	$('.contentText').css('height','auto');
	    	$('#viewMore').hide();
	    }
	  });

	  $(document).on('click', '#viewMore', function(){
	  	hei=$('.descriptionItem .contentText').height();
	  	//alert(hei);
	  	if (hei==170) { heigt='100%'; $(this).find('i').removeClass('fa-chevron-down'); $(this).find('i').addClass('fa-chevron-up');  }else{heigt='200px';  $(this).find('i').removeClass('fa-chevron-up'); $(this).find('i').addClass('fa-chevron-down');  }
	  	$('.descriptionItem .contentText').animate({
		    height: heigt
		  }, 500, function() {
		    // Animation complete.
		});

	  });

	  /*var textarea = document.getElementById('addComment');
	  textarea.addEventListener('keydown', autosize);  */    
	  var Theight=$( "#addComment" ).height();
	  //alert(height);
	  function autosize(){
	    var el = this;
	    setTimeout(function(){
	    	nh=el.scrollHeight-Theight;
	      //alert(nh);
	      if (nh>47) {el.style.cssText = 'height:' + el.scrollHeight + 'px';}
	    },0);
	  }
	  $(document).on('click', '#actionComment #cancelC', function(e)
	  {
	  	//alert('hbj');
	  	e.preventDefault();
	  	$( "#addComment" ).val('');
	  	$( "#addComment" ).css('height',47);
	  	$('.zonCommentButton').hide();
	  });

	  function templateComment(comment, allow){
	  	itemComment="";
	  	scope=60*(comment.level);

	  	//console.log(allow);
	  	
	  	//console.log(moment(comment.created).format('D MMMM YYYY, H:mm'));
	  	comment.created=moment(comment.created).format('D MMMM YYYY H:mm');
	  	firstletter=comment.user.first_name.charAt(0);
	  	secondletter=comment.user.last_name.charAt(0);
	  	lettericon=(firstletter+secondletter).toUpperCase();
	  	itemComment+='<li id="Comment_'+comment.id+'" class="listComment pb-0" style="padding-left:'+scope+'px; display:none;">';
	  	itemComment+='<div class="d-flex flex-row  pb-3 pl-3 pr-3 pt-3">';
	  	itemComment+='<div><div class="zonIcon">'+lettericon+'</div></div>';
	  	itemComment+='<div class="zoncomment" data-commentid="'+comment.id+'">';
	  	if (allow==true) { itemComment+='<button type="button" class="close"><span aria-hidden="true">×</span></button>'; }

	  	itemComment+='<div class="zonName"><strong>'+comment.user.first_name+' '+comment.user.last_name+'</strong></div>';
	  	itemComment+='<div class="zonDate"><small class="text-muted">'+comment.created+'</small></div>';
	  	itemComment+='<div id="contetmessage" class="repose"><div class="zonContentComment shadow-sm rounded">'+comment.message+'</div>';

	  	if (allow==true) {
	  	itemComment+='<div class="editComment" style="display:none;"><textarea placeholder="Adicionar comentario..." name="message'+comment.id+'" data-itemid="'+comment.item_id+'" data-commentid="'+comment.id+'" class="p-0 form-control border-0 zonContentComment shadow-sm rounded pl-3 pr-3 pt-3 pb-3 mt-0">'+comment.message+'</textarea>';
	  	itemComment+='<div class="text-right"><div class="btn-group" role="group"><button type="button" id="addC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Editar</button><button type="button" id="cancelC" class="btn btn-blue-grey btn-sm waves-effect waves-light">Cancel</button></div>';
	  	itemComment+='</div>';
	  	itemComment+='</div>';
	  	}


	  	itemComment+='</div>';
	  	itemComment+='</div>';
	  	itemComment+='</div>';
	  	itemComment+='</li>';
	  	return itemComment;
	  }
	  var relationItem;
	  socket.on('comment message', function(msg){
	  	itemId=$("#actionComment textarea").attr('data-itemid');
	  	if (itemId==msg.item_id) {
	  		equis=false;
	  		if (relationItem.role_id==3 && relationItem.user_id==msg.user_id || (relationItem.role_id==1 || relationItem.role_id==2)){
	  			equis=true;
	  		}
	  		itemComment=templateComment(msg, equis);
	  		$(".listComments").append(itemComment);
	  		$('body .countComments').text(msg.total_comments);
	  		$(".listComments li.listComment").last().show();
	  	}
	  });

	$(document).on('click', 'body #deleteItem', function(e)
	{
		var $this=$(this);
		itemId=$("#actionComment textarea").attr('data-itemid');
		$.confirm({
			theme: 'supervan',
		    title: 'Eliminar Item!',
		    content: '¿Está seguro de que desea <strong>permanentemente</strong> eliminar el Item?',
		    buttons: {
		        confirmar: function () {
		        	$.ajax({
		        		type: "POST",
		        		url: '/deleteItem/'+itemId,
		        		success: function(data){
		        			//console.log(data);
		        			$('#modalItem').modal('toggle');
		        			socket.emit('delete item', data);
		        		},
		        		error:function(xhr, e, etype){
		        			console.log("error");
		        		},
		        		dataType: 'json'
		        	});
		        },
		        cancelar: function () {}
		    }
		});
		return false;
	});
	$(document).on('click', '#blockAttachments #attFile .close, .blockFilesItem #deleteFile', function(e)
	{
		var $this=$(this);
		$.confirm({
			theme: 'supervan',
		    title: 'Eliminar Archivo!',
		    content: '¿Está seguro de que desea <strong>permanentemente</strong> eliminar el file?',
		    buttons: {
		        confirmar: function () {
		        	id=$this.parents('#attFile').attr('data-fileid');
		        	deleteElement('deleteFile',id);
		        },
		        cancelar: function () {}
		    }
		});
		return false;
	});
	$(document).on('click', '.listComments .listComment .close', function(e)
	{
		var $this=$(this);
		$.confirm({
			theme: 'supervan',
		    title: 'Eliminar!',
		    content: '¿Está seguro de que desea <strong>permanentemente</strong> eliminar el comment?',
		    buttons: {
		        confirmar: function () {
		        	id=$this.parents('.zoncomment').attr('data-commentid');
		        	deleteElement('deleteComment',id);
		        	//alert(id);
		        },
		        cancelar: function () {}
		    }
		});
	});
	function deleteElement(element,id){
		if (element=='deleteFile') {soco="file";}
		if (element=='deleteComment') {soco="comment";}
		$.ajax({
			type: "POST",
			url: '/'+element+'/'+id,
			success: function(data){
				//console.log(data);
				socket.emit('delete '+soco, data);
			},
			error:function(xhr, e, etype){
				console.log("error");
			},
			dataType: 'json'
		});
	}


	function templateAttach(file, allow){
		itemFile="";
		//var d = new Date(file.created);
		//console.log(allow);
		file.created=moment(file.created).format('D MMMM YYYY H:mm');
		//iconFile=openFile(file.filename);
		itemFile+='<dt class="col-sm-1 h4 m-0 blockfile'+file.id+'"><i class="fa '+file.icon+'"></i></dt>';
		itemFile+='<dd class="col-sm-11 small blockfile'+file.id+'" id="attFile" data-fileId="'+file.id+'">';
		itemFile+='<a href="/files/download/'+file.filename+'"><strong class="text-dark">'+file.name+'</strong><br> <span class="text-muted">'+file.user.first_name+' '+file.user.last_name+', '+file.created+', '+file.size+'</span></a>';
		if (allow==true) {
			itemFile+='<button type="button" class="close"><span aria-hidden="true">×</span></button>';
		}

		itemFile+='</dd>';
		return itemFile;
	}

	function templateAttach2(file, allow){
		itemFile="";
		//var d = new Date(file.created);
		//iconFile=openFile(file.filename);
		file.created=moment(file.created).format('D MMMM YYYY H:mm');
		itemFile+='<div class="col-sm-3 mt-4 blockfile'+file.id+'"><div class="blonit text-center rounded bg-light shadow p-1 z-depth-1 view overlay" id="attFile" data-fileid="'+file.id+'"><div class="tipoIcon fs-5 text-dark"><i class="fa '+file.icon+'"></i></div><div class="filecontent text-secondary"><strong class="text-dark" style="">'+file.name+'</strong><p><small>'+file.user.first_name+' '+file.user.last_name+', '+file.created+', '+file.size+'</small></p></div><div class="mask flex-center rgba-white-strong"><div class="text-center"><a href="/files/download/'+file.filename+'" class="btn btn-vk btn-md waves-effect waves-light"><i class="fa fa-download"></i></a>';
		if (allow==true) {
			itemFile+='<a href="#" id="deleteFile" class="btn btn-git btn-md waves-effect waves-light"><i class="fa fa-trash"></i></a>';
		}
		itemFile+='</div></div></div></div>';
		return itemFile;
	}

	socket.on('delete item', function(msg){
		itemId=msg;
		selectorItem='#timeline .timeline-item .timeline-content[data-itemid='+itemId+']';
		$(selectorItem).parents('.timeline-item').remove();
		count=1;
		$('#timeline .timeline-item').each(function( index, value ) {
			if (count==1) { 
				$(this).attr('floattype',''); 
				$(this).find('.timeline-content').removeClass('right'); 
				count=0; 
			}else{
				 $(this).attr('floattype','right');
				 $(this).find('.timeline-content').removeClass('right')
				 $(this).find('.timeline-content').addClass('right'); 
				 count++;
			}
		});
		window.location.href = "#item"+itemId;
	});

	socket.on('delete file', function(msg){
		itemId=$("#actionComment textarea").attr('data-itemid');
		if (itemId==msg.item_id) {
			filee=".blockfile"+msg.id;
			$('#blockAttachments, .blockFilesItem').find(filee).remove();
			//total
			toal=$('body .countAttachments').first().text();
			$('body .countAttachments').text(parseInt(toal-1));
		}
	});

	socket.on('delete comment', function(msg){
		itemId=$("#actionComment textarea").attr('data-itemid');
		console.log(msg);
		console.log(itemId);
		if (itemId==msg.item_id) {
			filee="#Comment_"+msg.id;
			$('.listComments').find(filee).remove();
			toal=$('body .countComments').first().text();
			$('body .countComments').text(parseInt(toal-1));
		}
	});

	socket.on('attach files', function(msg){
		itemId=$("#actionComment textarea").attr('data-itemid');
		files="";
		if (itemId==msg[0].item_id) {
			totalFiles=parseInt($('body .countAttachments').first().text());
			t=totalFiles+parseInt(msg.length);

			$('body .countAttachments').text(t);



			$.each(msg, function( index, value ) {
				equis=false;
				if (relationItem.role_id==3 && relationItem.user_id==value.user_id || (relationItem.role_id==1 || relationItem.role_id==2)){
					equis=true;
				} 

				if($('.blockFilesItem').length){
					files+=templateAttach2(value, equis);
				}else{
					files+=templateAttach(value, equis);
				}
			});
			$("#blockAttachments, .blockFilesItem .row#listFiles").append(files);
		}
	});
	/*$(document).on('click', '.descriptionItem #addC', function(e)
	{
		//editor.on("blur", function(){});
		$(this).focus();
	});*/
	$(document).on('click', '#actionComment #addC', function(e)
	{
		e.preventDefault();
		//alert('gsdf');
		$("#actionComment textarea").val(editorComments.getData());
		msg=$("#actionComment textarea").val();
		itemId=$("#addComment").attr('data-itemid');
		//alert(itemId);
		if (msg=='') { return false; }
		$.ajax({
			type: "POST",
			data: 'itemId='+itemId+'&msg='+msg,
			url: '/addComment/',
			success: function(data){
				$("#actionComment textarea").val('');
				$( "#addComment" ).css('height',47);
				$('.zonCommentButton').hide();
				socket.emit('comment message', data);
			},
			error:function(xhr, e, etype){
				console.log("error");
			},
			dataType: 'json'
		});
	});

	/*metodos para guardar campos individuales en item modal*/
	var este;
	$(document).on('click', '.listComments .zoncomment #contetmessage.repose', function(e)
	{
		//CKEDITOR.replace('employDesc');
		e.preventDefault();
		var texta=$(this).find('textarea').attr('name');
		var textaval=$(this).find('.zonContentComment').first().html();
		//var editor = CKEDITOR.instances[texta];
		
		var este=$(this);

		$(this).removeClass('repose');

		editorComment=CKEDITOR.inline( texta,
			{   toolbar:'MA'    }
		);


		editorComment.setData(textaval);
	  	setTimeout(function(){  editorComment.focus(); }, 150);

	  	$(this).find('.zonContentComment').first().hide();
	  	$(this).find('.editComment').show();

    	editorComment.on("blur", function(){

    		var edlete=this;

    		if(!este.find('.editComment .btn-group #cancelC:hover').length) {
    			valueactual=este.find('.zonContentComment').first().html();
    			valueN=edlete.getData();

    			comment_id=este.find('.editComment textarea').attr('data-commentid');
    			item_id=este.find('.editComment textarea').attr('data-itemid');
    			if(valueactual!=valueN && valueN!=''){
    				valueactual=valueN;
    				updateComment(item_id,comment_id,valueactual);
    			};
    		}

    		este.find('.zonContentComment').first().show();
    		este.find('.editComment').hide();
    		este.addClass('repose');

    		setTimeout(function() {
    		       edlete.destroy();
    		   },0);
    	});
	});

	function updateComment(item_id, comment_id, value){
		$.ajax({
			type: "POST",
			data: 'message='+value,
			url: '/editComment/'+comment_id,
			success: function(data){
				socket.emit('edit comment', data);
			},
			error:function(xhr, e, etype){
				console.log("error");
			},
			dataType: 'json'
		});
	}

	$(document).on('click', '#modalItem .modal-body .descriptionItem, body #itemSingle .descriptionItem', function(e){
		e.preventDefault();
		
		//console.log(editor);
		if(!$('body .descriptionItem .itemButton #addC:hover').length) {
			$('.descriptionItem .itemButton').show();
			$(this).find('.contentText, div.card-text').hide();
			$(this).find('.holder_item2').show();
			$(this).find('.holder_item2 #description').val($(this).find('.contentText, div.card-text').html());
			/*$(this).find('.holder_item2 #description').focus(autosize);
			$(this).find('.holder_item2 #description').focus();*/
			editor.focus();
		}
		
	});

	$(document).on('click', '#modalItem .modal-header .holder_item, body #itemSingle .holder_item', function(e){
		e.preventDefault();
		$(this).find('#name').val($('#modalItem .modal-header .modal-title span, #itemSingle h4.card-title strong').text());
		$('#modalItem .modal-header .itemButton, #itemSingle .headerItem .itemButton').show();
		$('#modalItem .modal-header .modal-title, #itemSingle h4.card-title strong').hide();
	});
	$('#modalItem .modal-header #name, #itemSingle #name').focusout(function(e){
		e.preventDefault();

		if(!$('#modalItem .modal-header .itemButton #cancelC:hover, #itemSingle .headerItem .itemButton #cancelC:hover').length) {
			item_id=$("#actionComment textarea").attr('data-itemid');
			valueN=$(this).val();
		    if(valuename!=valueN && valueN!=''){
		    	$('#modalItem .modal-header .modal-title span, #itemSingle h4.card-title strong').text($(this).val());
		    	updateSingle(item_id, 'name', valueN);
		    	valuename=valueN;
		    };
		}

		$('#modalItem .modal-header .modal-title, #itemSingle h4.card-title strong').show();
		$('#modalItem .modal-header .itemButton, #itemSingle .headerItem .itemButton').hide();
		//alert('ikjhi');
	});

	function updateSingle(item_id, field, value){
		//alert(item_id);
		$.ajax({
			type: "POST",
			data: field+"="+escape(value),
			url: '/editFront/'+item_id,
			success: function(data){
				socket.emit('edit '+field, data);
			},
			error:function(xhr, e, etype){
				console.log("error");
			},
			dataType: 'json'
		});
	}
	socket.on('edit comment', function(msg){
		itemId=$("#actionComment textarea").attr('data-itemid');
		if (itemId==msg.item_id) {
			equis=false;
			if (relationItem.role_id==3 && relationItem.user_id==msg.user_id || (relationItem.role_id==1 || relationItem.role_id==2)){
				equis=true;
			}
			itemComment=templateComment(msg, equis);

			idcom='.listComments #Comment_'+msg.id;

			$(idcom).replaceWith(itemComment);
			$(idcom).show();


			//$(".listComments").append(itemComment);
			$('#modalItem .modal-body .countComments').text(msg.total_comments);
			$(".listComments li.listComment").last().show();
		}

		express='#timeline  .timeline-content[data-itemid='+msg.id+']';
		ada=$(express).find('h2').text(msg.name);
	});
	socket.on('edit name', function(msg){
		express='#timeline .timeline-content[data-itemid='+msg.id+']';
		itemId=$("#actionComment textarea").attr('data-itemid');
		privateElement='<i data-toggle="tooltip" data-placement="top" title="Item privado" class="fa fa-lock prefix grey-text"></i>';
		//
		//console.log();
		$(express).find('h2').text(msg.name);
		if (msg.private) { $(express).find('h2').prepend(privateElement); }
		
		if (itemId==msg.id) {
			if (msg.private) { 
				$('#modalItem .modal-header .modal-title').html(privateElement+" "+msg.id+":<span></span>");
				 }
			$('#modalItem .modal-header .modal-title span, #itemSingle h4.card-title strong').text(msg.name);
			$('#modalItem .modal-header .holder_item #name, #itemSingle .headerItem .holder_item #name').val(msg.name);
		}		
	});
	socket.on('edit description', function(msg){
		express='#timeline  .timeline-content[data-itemid='+msg.id+']';
		itemId=$("#actionComment textarea").attr('data-itemid');
		$(express).find('.bodytextItem').html(msg.description);
		if (itemId==msg.id) {
			$('#modalItem .modal-body .descriptionItem .contentText, #itemSingle .descriptionItem div.card-text').html(msg.description);
			$('#modalItem .modal-body .descriptionItem .holder_item2 #description, #itemSingle .descriptionItem .holder_item2 #description').val(msg.description);
			editor.setData(msg.description);
		}
	});
	/*-------------------------------------------------------------------------------*/

	var valuedescription, valuename;
	
	$(document).on('click', '#timelineContent .timeline-content', function(e)
	{
		//var thisItem=$(this);
		e.preventDefault();
		$('#viewMore').hide();
		$('.contentText').css('height','auto');
		itemid=$(this).attr( "data-itemid" );
		$.ajax({
			type: "GET",
			url: '/item/'+itemid,
			success: function(data){
				//alert(data.comments.length);
				if (data.item.comments.length>3) { $('#showEarlierComments').show(); }
				relationItem=data.relationItem;
				valuedescription=data.item.description;
				valuename=data.item.name;
				privateElement='<i data-toggle="tooltip" data-placement="top" title="Item privado" class="fa fa-lock prefix grey-text"></i> ';
				if (!data.item.private) { privateElement="";}
				$('#modalItem .modal-title').html(privateElement+data.item.id+":<span>"+data.item.name+"</span>");
				$('#modalItem .holder_item #name').val(data.item.name);
				$('#modalItem .holder_item2 #description').val(data.item.description);
				$('#modalItem .modal-body .descriptionItem .contentText').html(data.item.description);
				$('#modalItem .modal-body .barInfo .dateItem span').text(data.item.createdFormat);	
				$('#modalItem .modal-body .barInfo .byItem span').text(data.item.user.first_name+" "+data.item.user.last_name);
				$('#modalItem .modal-body .barInfo .typeItem span').text(data.item.type_item.name);
				if (data.item.room) {room_name=data.item.room.name;}else{room_name="Sin definir"}
				$('#modalItem .modal-body .barInfo .companyItem span').text(data.item.company.name);	
				$('#modalItem .modal-body .barInfo .roomItem span').text(room_name);	
				$('#modalItem #btn_view_more').attr('href','/item/'+data.item.id);	
				$('#modalItem .modal-body .countComments').text(data.item.comments.length);
				$('#modalItem .modal-body .countAttachments').text(data.item.files.length);
				editor.setData(data.item.description);
				//console.log(data);

				itemComment="";
				$.each(data.item.comments, function( index, value ) {
				 // console.log( index + ": " + value );
				 equis=false;
				 if (data.relationItem.role_id==3 && data.relationItem.user_id==value.user_id || (data.relationItem.role_id==1 || data.relationItem.role_id==2)){
				 	equis=true;
				 }

				  itemComment+=templateComment(value,equis);
				});
				$( ".listComments" ).html( itemComment );



				count=0;
				$('.listComments li.listComment').reverse().each(function(){ 
					count++;
					if (count<=3) {
						$(this).show();
					}
				});
				$('.listComment .zoncomment .editComment textarea').keydown(autosize);

				itemFile="";
				$.each(data.item.files, function( index, value ) {
					equis=false;
					if (data.relationItem.role_id==3 && data.relationItem.user_id==value.user_id || (data.relationItem.role_id==1 || data.relationItem.role_id==2)){
						equis=true;
					}
				  itemFile+=templateAttach(value,equis);
				});
				$( "#blockAttachments" ).html( itemFile );


				$( "#actionComment textarea" ).attr('data-itemId',itemid);
				//console.log(data.comments);
				$('#modalItem').modal({
					focus: false
				});

			},
			error:function(xhr, e, etype){
				console.log("error");
			},
			dataType: 'json'
		});
	});
	

	$('.listComment .zoncomment .editComment textarea').keydown(autosize);

	<?php if (count($companies)==0) { ?>
	    $('#modalWithouCompanies').modal({
	        backdrop: 'static',
	        keyboard: false  // to prevent closing with Esc button (if you want this too)
	    });
	<?php }else{ ?>

	$('body #btnAddUser').click(function(){
	  foreingkey=$(this).data( "foreingkey" );
	  model=$(this).data( "model" );

	  $('#modalNuevoUsuario #foreign_key').val(foreingkey);
	  $('#modalNuevoUsuario #model').val(model);
	  //foreign_key

	  $('#modalNuevoUsuario').modal({
	     // backdrop: 'static',
	     // keyboard: false  // to prevent closing with Esc button (if you want this too)
	  });
	  return false;
	}); 
	$('#addModalRoom').click(function(){
	  $('#sidenav-overlay').click();
	});  
	$('form button[type=submit]').click(function(){
		//alert('gsdf');
		//valid select
		formu=$(this).parents('form:first');
		//var form = $(this).parents('form:first');
		//console.log(formu);
		selector=$(formu).find('.select-wrapper.selectCol');
		$(selector).each(function() {
			valor=$(this).find('select').val();
			if (valor==null) {
				$(this).addClass('invalid');
				$(this).removeClass('valid');
				return false;
			}else{
				$(this).addClass('valid');
				$(this).removeClass('invalid');
			}
		});
	});

	$('#selectCompany').click(function(){
	    $('#sideBCompanies > a').click();
	});
	$('#sectNbutton').fadeOut();
	var odatetime='<?php echo $time; ?>';
	setInterval(function(){ 

		//alert('yeah');
		$.ajax({
			type: "GET",
			data: 'checkNews='+odatetime,
			success: function(data){
				if (data>0) {
					$('#sectNbutton').fadeIn();
				}
			},
			error:function(xhr, e, etype){
				console.log("error");
			},
			dataType: 'json'
		});
	}, 5000);



	$(window).on('scroll ready', function(){


		//console.log($(this).scrollTop());
		$('.sidenav').css('padding-top', 0);
		if ($(this).scrollTop()>50) {
			$('.sidenav').css('padding-top', 0);
		}else{
			$('.sidenav').css('padding-top', 50-($(this).scrollTop()));
		}
		//console.log($(this).scrollTop());
		scrollNow=$('main').offset();
		scrollNowheight=$('main').height();
		//scrollNow=scrollNow.top+scrollNowheight-521;
		scrollNow=scrollNow.top;
		//console.log($(this).scrollTop());
		//console.log('-');
		//console.log(scrollNow);
        if ($(this).scrollTop() > (scrollNow)) {
            $('.scrollToBottom').fadeIn();
            $('#sectNbutton').addClass('active');
        } else {
            $('.scrollToBottom').fadeOut();
            $('#sectNbutton').removeClass('active');
        }
	});

	$('.scrollToBottom').click(function(){
		scrollNow=$('main').offset();
		scrollNowheight=$('main').height();
		
		scrollNow=scrollNow.top+scrollNowheight;
		//console.log(scrollNow);
        $('html, body').animate({scrollTop : 0},800);
        return false;
    });
    $('#modalNuevoUsuario').on('hidden.bs.modal', function () {
    	$('#process').val(0);
    	$('#users-email, #collaborator-menssage').val('');
    	$('#users-email, #collaborator-menssage').removeClass('valid invalid');
    	/*select*/
    	$('#collaborator-roles').material_select('destroy');
    	$('#collaborator-roles').val('').change();
    	$('#collaborator-roles').material_select();
    	//fin select
    	$('#newCollaborator .modal-footer button').show();
    	$('button.aceptModal').hide();
    	$('button.sendNotiModal').hide();
    	$('#process1').fadeOut("slow", function() {
    		$('#process0').fadeIn();
    	});

    })
    $(document).on('click','button.aceptModal, button.cancelModal, button.sendNotiModal',function(e){ 
    	$('#process').val(0);
    	if ($(this).hasClass('sendNotiModal')) {
    		$('#process').val(2);
    		$('#newCollaborator').submit();
    	}
    	
    	$('#users-email, #collaborator-menssage').val('');
    	$('#users-email, #collaborator-menssage').removeClass('valid invalid');
    	/*select*/
    	$('#collaborator-roles').material_select('destroy');
    	$('#collaborator-roles').val('').change();
    	$('#collaborator-roles').material_select();
    	//fin select
    	if (!$(this).hasClass('sendNotiModal')) {
	    	$('#newCollaborator .modal-footer button').show();
	    	$('button.aceptModal').hide();
	    	$('button.sendNotiModal').hide();
	    	$('#process1').fadeOut("slow", function() {
	    		$('#process0').fadeIn();
	    	});
    	}

    });
	$(document).on('submit','#newCollaborator, #newRoom, #newItem',function(e){ 
		//console.log(fileobj);
		//files=fileobj;

		action=$(this).attr('action');
		typeAdd=$(this).attr('id');
		//var gege = new FormData();
		var formData = new FormData($(this)[0]);
		//formData.append('egwg', 'fdh');
		//console.log(fileobj.length);
		$.each(fileobj, function( index, value ) {
			//file[index]=value
			//console.log("yeah");
			formData.append('files[]', value);
		});
		//postData = $(this).serialize();
		//console.log(gege);
		
		$.ajax({
			type: "POST",
			url: action,
			data: formData,
			processData: false,
			contentType: false,
			success: function(data){
				if (typeAdd=='newRoom') {
					window.location.replace("/company/"+data.company_id+"/room/"+data.id);
				}	
				if (typeAdd=='newItem') {
					//return false;
					if (data.room_id) {
						window.location.replace("/company/"+data.company_id+"/room/"+data.room_id);
					}else{
						window.location.replace("/company/"+data.company_id);
					}
					
				}	
				if (typeAdd=='newCollaborator') {
					if (data==0) {
						$('#process').val(1);
						$('#process1').text('El destinatario no tiene cuenta en comunicatec.es, desea continuar y enviar la invitación?');
						$('#process0').fadeOut("slow", function() {
							$('#process1').fadeIn();
						});
					}else if(data==1){
						$('#process1').text('La invitación se ha enviado satisfactoriamente.');
						$('#newCollaborator .modal-footer button').hide();
						$('#newCollaborator .modal-footer button.aceptModal').show();
						$('#process0').fadeOut("slow", function() {
							$('#process1').fadeIn();
						});
					}else if(data==2){
						$('#process1').text('Una invitación similar se ha enviado anteriormente, deseas enviar un email para volver a notificar?');
						$('#newCollaborator .modal-footer button').hide();
						$('#newCollaborator .modal-footer button.sendNotiModal').show();
						$('#newCollaborator .modal-footer button.cancelModal').show();
						$('#process0').fadeOut("slow", function() {
							$('#process1').fadeIn();
						});
					}
					//window.location.href=window.location.href;
				}				
			},
			error:function(xhr, e, etype){
				console.log("error");
			},
			dataType: 'json'
		});
		return false;
	});
	function itemsHtml(item){
		$nameAncla='item'+item.id;
		
		$timeItem='<a name="'+$nameAncla+'" id="'+$nameAncla+'"></a>';
		$timeItem+='<div class="timeline-item" floattype="'+rightF+'">';
		$timeItem+='<div class="timeline-icon">'+item.createdFormat+'</div>';
		$timeItem+='<div class="timeline-content '+rightF+'" data-itemId="'+item.id+'">';
		//$timeItem+='<h2>'+item.id+'</h2>';
		$timeItem+='<h2>'+item.name+'</h2>';
		$timeItem+='<div class="row">';

		$timeItem+='<div class="col-sm-9"><p>';
		$timeItem+='<strong>Creado por:</strong> <a href="'+item.user_link+'">'+item.user.first_name+" "+item.user.last_name+'</a>, ';
		$timeItem+='<strong>Tipo:</strong> <a href="'+item.type_item_link+'">'+item.type_item.name+'</a>, ';
		if (item.room) {$timeItem+='<strong>Sala:</strong> <a href="'+item.room_link+'">'+item.room.name+'</a>, ';}else{$timeItem+='<strong>Sala:</strong> Sin definir, ';}
		
		$timeItem+='<strong>Empresa:</strong> <a href="'+item.company_link+'">'+item.company.name+'</a>';
		$timeItem+='</p></div>';

		$timeItem+='<div class="col-sm-3 text-right">';
		$timeItem+='<button type="button" data-toggle="modal" data-target="#modalNuevoUsuario" class="btn btn-dark btn-sm"><i class="fa  fa-user-plus fa-sm pr-2" aria-hidden="true"></i></button>';
		$timeItem+='</div>';

		$timeItem+='</div>';
		if (item.type_item_id==1 && item.additional_fields) {
			$timeItem+='<p><strong>Fecha reunión:</strong> '+item.additional_fields.fecha_reunion+' '+item.additional_fields.hora_reunion+'</p>';
			//console.log(item);
		}else if (item.type_item_id==2 && item.additional_fields) {
			$timeItem+='<p><strong>Fecha vencimiento:</strong> '+item.additional_fields.fecha_vencimiento+' '+item.additional_fields.hora_vencimiento+'</p>';
		}
		//console.log(item.type_item_id);
		$timeItem+='<div class="bodytextItem">'+item.description+'</div>';
		$timeItem+='</div>';
		$timeItem+='</div>';
		return $timeItem;
	}
	var lastClick=0;
	//var currentdate;
	//var odatetime;

	$('#sectNbutton button').click(function(){
		if (lastClick==0) {
			datetime='<?php echo $time; ?>';
			lastClick=1;
		}else{
			datetime=odatetime;
		}

		$.ajax({
			type: "GET",
			data: 'getAllNews='+datetime,
			success: function(items){
				$timeItemGroup="";
				count=0;
				rightF='';
				odatetime=items[0];
				rightF=$('.timeline-item').first().attr('floattype');
				//alert(rightF);
				items[1].reverse();

				$('#timeline').prepend("<div id='blocknewitems'><a name='newItems' id='newItems'></a><div class='newItemsAncla'><i class='fa fa-arrow-up'></i><span>Nuevos items</span></div></div>");
				items[1].forEach(function(item, index, array) { count++;  if (rightF=='right') { rightF=""; }else{ rightF='right'; } 

					if (count==1) {itemAncla="item"+item.id;}
					

				  $nextBut=item.nextButton;

				  $timeItemGroup=itemsHtml(item);
				  $('#timeline').prepend($timeItemGroup);
				  if (count === array.length) {
				  	//alert(count);
		               $('#sectNbutton').fadeOut();
		               //window.location.href = "#newItems";
		               idItemAncla="#"+itemAncla;
		               scrollNow=$('#newItems').offset();
		               console.log(scrollNow);

		               var body = $("body, html");
		               var top = body.scrollTop(); // Get position of the body
		               //if(top!=0){
		                      body.animate({scrollTop :scrollNow.top-500}, 700,function(){
		                        //DO SOMETHING AFTER SCROLL ANIMATION COMPLETED
		                         //alert('Hello');
		                     });
		           }
				});

				setTimeout(function(){ $('#blocknewitems').fadeOut("slow", function() {
										$('#blocknewitems').remove();
										}); }, 10000);

				//loadActionItems();

			},
			error:function(xhr, e, etype){
				console.log("error");
			},
			dataType: 'json'
		});
	});
	$('.buttonSectionTop a').click(function(){
		url=$(this).attr('href');
		$.ajax({
			type: "GET",
			url: url,
			data: 'date=<?php echo $time; ?>',
			success: function(items){
				//console.log(items);
				count=0;
				$timeItemGroup="";
				firstitem=$('.timeline-item').last().attr('floattype');
				//console.log(firstitem);
				rightF=firstitem;
				//n = $(items).length;
				/*console.log(firstitem);
*/
				/*if (n==2) {
					if (rightF=='right') { rightF=""; }else{ rightF='right'; }
				}*/
				//console.log(rightF);
				items.forEach(function(item) { count++;  if (rightF=='right') { rightF=""; }else{ rightF='right'; } 

				  $nextBut=item.nextButton;

				  $timeItemGroup+=itemsHtml(item);
				});

				$('.buttonSectionTop a').addClass('disabled');
				if ($nextBut) {
					$('.buttonSectionTop a').removeClass('disabled');
					$('.buttonSectionTop a').attr('href',$nextBut);
				}
				$('#timeline').append($timeItemGroup);
				//window.location.href = "#"+$nameAncla;

				scrollNow=$("#"+$nameAncla).offset();

				var body = $("body, html");
				var top = body.scrollTop() // Get position of the body
				//if(top!=0){
				       body.animate({scrollTop :scrollNow.top-90}, 700,function(){
				         //DO SOMETHING AFTER SCROLL ANIMATION COMPLETED
				          //alert('Hello');
				      });
				//loadActionItems();
				//}						
			},
			error:function(xhr, e, etype){
				console.log("error");
			},
			dataType: 'json'
		});
		return false;
	});
<?php } ?>/*
$(document).on({'show.bs.modal': function () {
                 $(this).removeAttr('tabindex');
      } }, '.modal');*/
</script>
