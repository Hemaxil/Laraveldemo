


	/* To check if the top checkbox was checked*/
	$("#head").change(function(){
		if($(this).prop("checked")){
			$("input[type='checkbox']").prop("checked",true);
		}else{
			$("input[type='checkbox']").prop("checked",false);
		}
	});

	/*For all the product checkboxes*/
	$("input[type='checkbox']:not([id='head'])").each(function(){
		$(this).change(function(){
			if ($(this).prop("checked")==false){
			$("#head").prop("checked",false);
		}

		});

	});
	/*Ajax call for multiple delete*/

	function ajax_call_delete(url,data){
		console.log(url);
		return $.ajax({
			url:url,
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{'ids':data},
            type: "delete",
		});
	};

	
	function delete_btn(url){
		$("#delete_btn").click(function(){
		$id=[];
		$("input[type='checkbox']:not([id='head'])").each(function(){
			if($(this).prop("checked")==true){
				$id.push($(this).attr('id'));
			}
		});
		$to_be_deleted=$id.join('+');
		if($to_be_deleted==""){
			alert("Please select atleast one entry");
		}else{
			$del_confirm=confirm("Are you sure you want to delete??");
			if($del_confirm==true){
				console.log(url,$to_be_deleted);
				$url=url;
				ajax_call_delete($url,$to_be_deleted).done(function(data){
	        		let result=$.parseJSON(data);
	        		console.log(result);
	            	$.each(result,function(index,value){
	            		$("#table_body #"+value).parent('td').parent('tr').remove();
	            	});


	        	});
	                
	        }	
		}
	});

	};


	function ajax_call_status(url,status_val,id){
		return $.ajax({
			url:url,
			headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
			data:{'status_val':status_val,'id':id},
            type: "patch",
		});

	};


	function update_status(url){
		$("a[class*='status-']").click(function(){
		$(this).each(function(){
		let class_inp=(this.className).split('-');
		let status_val=class_inp[1];
		let id=class_inp[2];
		ajax_call_status(url,status_val,id).done(function(data){
			[id,status]=$.parseJSON(data);
			//console.log(id,status);
			let class_name_prev=(status==true) ? '.status-0-'+id :'.status-1-'+id;
			let new_class_name= (status==true) ? '.status-1-'+id :'.status-0-'+id;
			//console.log(class_name_prev,new_class_name);
			$(class_name_prev).hide();
			$(new_class_name).show();
		});
	});
	});
	}


