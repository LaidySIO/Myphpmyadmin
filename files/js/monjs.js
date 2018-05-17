$(document).ready(function(){
	check_column = 0;

	/* ################################################## Page database.php ################################################## */
	if($("input[name$='page_name']").attr("id") == "databases")
	{
		$.ajax({
			url: '../functions/ajax.php',
			data: 'load_database=ok',
			type: 'POST',
			success: function(ok)
			{
				$("#list_db").append(ok);
			},
			error: function(){
				alert("Erreur Creation BAse de Données");
			}
		});

		$("#create_database").click(function(){ //Boutton creer database
			event.preventDefault();
			name = $("#dbname").val();
			if(name != undefined && name.length > 1)
			{
				$.ajax({
					url: '../functions/ajax.php',
					data: 'database_name='+name+'&create_database=ok',
					type: 'POST',
					success: function(ok)
					{
						alert("Base de données "+ name + "créée avec succès");
					},
					error: function(){
						alert("Erreur Creation Base de Données");
					}
				});
			}
			else{
				alert("Veuillez saisir un nom pour la base de données");
			}

		});

		$(document).on('click','.icon-delete',function(){ //Icone supprimer database
			target = $(this).attr("id");
			if (confirm('Souhaitez-vous supprimer la base '+target)) {
				$.ajax({
					url: '../functions/ajax.php',
					data: 'target='+target+'&drop_database=ok',
					type: 'POST',
					success: function(ok)
					{
						alert("Base " + target + " suprimée")
					},
					error: function(){
						alert("Erreur Creation Base de Données")
					}
				});
			}
		});
	}
	/* ##################################################  page edit.databases.php ##################################################*/
	if($("input[name='page_name']").attr("id") == "edit_databases") 
	{
		target = $("input[name='db_target']").attr("id");
		$.ajax({ //On génère le champs de modification du nom de la base
			url: '../functions/ajax.php',
			data: 'target='+target+'&edit_database=ok',
			type: 'POST',
			success: function(ok)
			{
				$("#form_database").append(ok);
				$.ajax({ //On recupère les infos sur la BDD
					url: '../functions/ajax.php',
					data: 'target='+target+'&load_dbinfos=ok',
					type: 'POST',
					success: function(oky)
					{
						$("#infos_database").append(oky);
						$.ajax({ //On genere le champs de création d'une table
							url: '../functions/ajax.php',
							data: 'target='+ target +'&form_table=ok',
							type: 'POST',
							success: function(ok)
							{
								$("#create_table").append(ok);
							},
							error: function(){
								alert("Erreur Creation Base de Données")
							}
						});
					},
					error: function(){
						alert("Erreur Creation Base de Données")
					}
				});
			},
			error: function(){
				alert("Erreur Creation Base de Données")
			}
		});
		$(document).on('click','#rename_database',function(){ //Boutton renommer database
			event.preventDefault();
			oldname = $("input[name='db_target']").attr("id");
			newname = $("#dbname").val();
			if(newname != undefined && name.length > 1)
			{
				if (confirm('Souhaitez-vous modifier le nom de la base '+oldname)) {
					$.ajax({
						url: '../functions/ajax.php',
						data: 'database_oldname='+oldname+'&database_newname='+newname+'&rename_database=ok',
						type: 'POST',
						success: function(ok)
						{
							alert(ok);
						//alert("Base de données "+ name + "modifiée avec succès");
					},
					error: function(){
						alert("Erreur Creation Base de Données");
					}
				});
				}
			}
			else{
				alert("Veuillez saisir un nom pour la base de données");
			}

		});

		$(document).on('click','.icon-delete',function(){ //Icone supprimer Table
			target = $(this).attr("name");
			db = $("input[name='db_target']").attr("id");

			if (confirm('Souhaitez-vous supprimer la table '+target)) {
				$.ajax({
					url: '../functions/ajax.php',
					data: 'db='+db+'&target='+target+'&drop_table=ok',
					type: 'POST',
					success: function(ok)
					{
						alert("table " + target + " suprimée")
					},
					error: function(){
						alert("Erreur Suppression de la table")
					}
				});
			}
		});

		$(document).on('click','#create_table_form',function(){ //boutton valider nom de la nouvelle table
			
			db = $("input[name='db_target']").attr("id");
			if(check_column == 0 && tablename != undefined &&  $("#tablename").val().length > 2 )
			{
				$.ajax({
					url: '../functions/ajax.php',
					data: 'column_arg=ok',
					type: 'POST',
					success: function(ok)
					{
						$("form[name='createtable']").append(ok);

					},
					error: function(){
						alert("Erreur Suppression de la table")
					}
				});
			}
			else if($("#typesize").val() < 33 ){
				tablename = $("#tablename").val();
				columnname = $("#columnname").val();
				type = $("#typeselect").find(":selected").text();
				size = $("#typesize").val();
				nulle = $("#null").prop("checked");
				auto = $("#auto").prop("checked");
				$.ajax({
					url: '../functions/ajax.php',
					data: 'db='+db+'&tablename='+tablename+'&columnname='+columnname+'&type='+type+'&size='+size+'&null='+nulle+'&auto='+auto+'&create_table=ok',
					type: 'POST',
					success: function(ok)
					{
						alert(ok);
					},
					error: function(){
						alert("Erreur création de la table")
					}
				});
			}
			
			check_column = 1;
		});


	}

	/* ################################################## Page tables.php ################################################## */
	if($("input[name$='page_name']").attr("id") == "tables")
	{
		$.ajax({
			url: '../functions/ajax.php',
			data: 'load_tables=ok',
			type: 'POST',
			success: function(ok)
			{
				$("#list_table").append(ok);
			},
			error: function(){
				alert("Erreur Creation Base de Données");
			}
		});


		$(document).on('click','.icon-delete',function(){ //Icone supprimer table
			target = $(this).attr("id");
			if (confirm('Souhaitez-vous supprimer la base '+target)) {
				$.ajax({
					url: '../functions/ajax.php',
					data: 'target='+target+'&drop_database=ok',
					type: 'POST',
					success: function(ok)
					{
						alert("Base " + target + " suprimée")
					},
					error: function(){
						alert("Erreur Creation Base de Données")
					}
				});
			}
		});
		$(document).on('click','.table-primary',function(){ // Afficher tables
			$(this).nextUntil(".table-primary").toggle("fast");
		});
	}

	/* ################################################## Page edit.tables.php ################################################## */

	if($("input[name='page_name']").attr("id") == "edit_tables") 
	{
		db = $("input[name='db_target']").attr("id");
		target = $("input[name='table_target']").attr("id");
		$.ajax({
			url: '../functions/ajax.php',
			data: 'target='+target+'&edit_table=ok',
			type: 'POST',
			success: function(ok)
			{
				$("#form_table").append(ok);
				$.ajax({
					url: '../functions/ajax.php',
					data: 'dbname='+db+'&target='+target+'&load_tableinfos=ok',
					type: 'POST',
					success: function(oky)
					{
						$("#infos_table").append(oky);
					},
					error: function(){
						alert("Erreur Creation Base de Données")
					}
				});
			},
			error: function(){
				alert("Erreur Creation Base de Données")
			}
		});
		
		$(document).on('click','#rename_table',function(){ //Boutton renommer table
			event.preventDefault();
			oldname = $("input[name='table_target']").attr("id");
			newname = $("#tablename").val();
			db = $("input[name='db_target']").attr("id");
			if(newname != undefined && newname.length > 1)
			{
				$.ajax({
					url: '../functions/ajax.php',
					data: 'db='+db+'&table_oldname='+oldname+'&table_newname='+newname+'&rename_table=ok',
					type: 'POST',
					success: function(ok)
					{
						alert("Table "+ name + "modifiée avec succès");
					},
					error: function(){
						alert("Erreur Creation Base de Données");
					}
				});
			}
			else{
				alert("Veuillez saisir un nom pour la base de données");
			}

		});


	}

		/* ################################################## Page request.php ################################################## */

	if($("input[name='page_name']").attr("id") == "request") 
	{
		alert("hello");
		$(document).on('click','#execute_query',function(){ //Boutton renommer table
			event.preventDefault();
			alert($("textarea#request").val());
			query = $("textarea#request").val();

			if( query != undefined )
			{
				$.ajax({
					url: '../functions/ajax.php',
					data: 'query='+query+'&execute_query=ok',
					type: 'POST',
					success: function(ok)
					{
						alert(ok);
						if(ok == 1)
						{
							alert("Requête correctemen executée");
						}
						else{
							alert("Veuillez verifier la syntaxe de votre requête\nErreur lors de l'execution")
						}
					},
					error: function(){
						alert("Erreur Execution Requete");
					}
				});
			}
			else{
				alert("Veuillez saisir une requete");
			}

		});

	}
		
	
});