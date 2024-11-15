INSERT INTO `{tbl_prefix}languages` (`language_name`, `language_active`, `language_default`, `language_code`)
VALUES ('Portuguesa', 'yes', 'no', 'pt-BR');

SET @language_id = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');

INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_name_error'), 'Por favor, insira um nome para o anúncio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_exists_error1'), 'O anúncio não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_exists_error2'), 'Erro: Anúncio com este nome já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_add_msg'), 'Anúncio adicionado com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_msg'), 'O anúncio foi ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_update_msg'), 'O anúncio foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_del_msg'), 'Anúncio foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_deactive'), 'Desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_active'), 'Ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placment_delete_msg'), 'O posicionamento foi removido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placement_err1'), 'O posicionamento já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placement_err2'), 'Por favor, digite um nome para o posicionamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placement_err3'), 'Por favor, digite um código para o posicionamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placement_msg'), 'O posicionamento foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_exist_error'), 'A categoria não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_add_msg'), 'Categoria foi adicionada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_update_msg'), 'A categoria foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_install_msg'), 'O plugin foi instalado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_no_file_err'), 'Nenhum arquivo encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_file_detail_err'), 'Detalhes do plugin desconhecido encontrados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_installed_err'), 'Plugin já instalado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_no_install_err'), 'O plugin não está instalado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_comment_msg'), 'O comentário foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cpass_err'), 'A senha de confirmação não corresponde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_err'), 'A senha antiga está incorreta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cpass_err1'), 'Confirmação de senha incorreta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cmt_del_msg'), 'O comentário foi excluido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_sub_err'), 'Você já está inscrito em %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_exist_err'), 'O usuário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_err'), 'Nome de usuário está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_err2'), 'Nome de usuário já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_err2'), 'A senha está vazia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_email_err1'), 'E-mail está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_email_err2'), 'Por favor, insira um endereço de e-mail válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_email_err3'), 'O endereço de e-mail já está em uso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_err3'), 'Nome de usuário contém caracteres não permitidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_err3'), 'Senhas não Correspondentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ament_err'), 'Desculpe, você precisa concordar com os termos de uso e política de privacidade para criar uma conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_reg_err'), 'Desculpe, os registros não estão permitidos temporariamente. Por favor, tente novamente mais tarde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ban_err'), 'Conta de usuário banida, entre em contato com o administrador do site');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_login_err'), 'Nome de usuário e senha não correspondem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_sub_msg'), 'Você agora é um inscrito de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_email_msg'), 'Enviamos um e-mail para você contendo seu nome de usuário, por favor verifique-o');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_rpass_email_msg'), 'Um e-mail foi enviado para você. Siga as instruções lá para redefinir sua senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_email_msg'), 'A senha foi alterada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_del_msg'), 'O usuário foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ac_msg'), 'O usuário foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_dac_msg'), 'O usuário foi desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uban_msg'), 'O usuário foi banido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uuban_msg'), 'O usuário foi desbanido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_upd_succ_msg'), 'O usuário foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_msg'), 'Sua conta foi ativada. Agora você pode fazer login em sua conta e enviar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_err'), 'Este usuário já está ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_em_msg'), 'Enviamos um e-mail contendo o seu código de ativação. Por favor, verifique sua caixa de correio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pof_upd_msg'), 'O perfil foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_no_ans'), 'Sem resposta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_elementary'), 'Fundamental');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_hi_school'), 'Ensino médio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_some_colg'), 'Alguma Faculdade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_assoc_deg'), 'Grau associado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_bach_deg'), 'Bacharelado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_mast_deg'), 'Mestrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_phd'), 'Ph.D.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_post_doc'), 'Postdoutorado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_single'), 'Solteiro(a)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_married'), 'Casado(a)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_comitted'), 'Comprometido(a)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_open_relate'), 'Relacionamento Aberto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_crt_new_msg'), 'Compor Nova Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_usr_fav_vids'), 'Vídeos Favoritos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_iac_msg'), 'Vídeo está Inativo - Por favor contate o Administrador para mais detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_error_occured'), 'Desculpe, Ocorreu um erro');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_cat_del_msg'), 'A categoria foi excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_del_msg'), 'O vídeo foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_fr_msg'), 'O vídeo foi marcado como «Vídeo em Destaque»');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_fr_msg1'), 'O vídeo foi removido de «Vídeos em destaque»');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_act_msg'), 'O vídeo foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_act_msg1'), 'O vídeo foi desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_update_msg'), 'Detalhes do vídeo atualizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_invalid_user'), 'Nome de usuário inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_subj_err'), 'Assunto da mensagem está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_del_err'), 'O vídeo não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_unsub_msg'), 'Sua assinatura foi cancelada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_exist_err'), 'Desculpe, o vídeo não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_forgot_username'), 'Esqueceu seu Usuário | Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_manage_vids'), 'Gerenciar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_my_inbox'), 'Minha Caixa de Entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_my_channel'), 'Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_manage_fav'), 'Gerenciar Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_manage_subs'), 'Gerenciar Inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_advance_results'), 'Busca avançada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_viewed'), 'Mais Vistos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'featured'), 'Em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'about_us'), 'Sobre nós');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'account'), 'Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'all'), 'Todos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'active'), 'Ativo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'activate'), 'Ativar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'deactivate'), 'Desativar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'by'), 'por');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cancel'), 'Cancelar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'categories'), 'Categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'category'), 'Categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channels'), 'Canais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comments'), 'Comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comment'), 'Comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'companies'), 'Empresas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'contact_us'), 'Contate-nos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'country'), 'País');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date'), 'Data');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date_added'), 'Data de Adição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete'), 'Excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add'), 'Adicionar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete_selected'), 'Excluir Selecionados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'duration'), 'Duração');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'education'), 'Educação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email'), 'E-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'embed_code'), 'Código de Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'favourites'), 'Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'female'), 'Mulher');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friends'), 'Amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'from'), 'De');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'gender'), 'Sexo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'help'), 'Ajuda');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hobbies'), 'Passatempos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'inbox'), 'Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'joined'), 'Juntou-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'location'), 'Localização');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'login'), 'Entrar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'logout'), 'Sair');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'male'), 'Homem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'members'), 'Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'messages'), 'Mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'message'), 'Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'minute'), 'minuto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'minutes'), 'minutos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_recent'), 'Mais Recente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_account'), 'Minha Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'next'), 'Próxima');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no'), 'Não');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'optional'), 'opcional');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'password'), 'senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'privacy_policy'), 'Política de Privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'request'), 'Solicitar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'reply'), 'Responder');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'second'), 'segundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'seconds'), 'segundos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'send'), 'Enviar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'sent'), 'Enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup'), 'Criar conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subject'), 'Assunto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'tags'), 'Tags');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'to'), 'Para');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type'), 'Tipo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update'), 'Atualizar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload'), 'Enviar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'videos'), 'Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'website'), 'Página Web');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'yes'), 'Sim');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'previous'), 'Anterior');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'rating'), 'Avaliação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remote_upload'), 'Envio Remoto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove'), 'Remover');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'search'), 'Pesquisar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'services'), 'Serviços');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subscribers'), 'Inscritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'tag_title'), 'Tags');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'track_title'), 'Faixa de áudio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'username'), 'Nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'views'), 'Visualizações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mostly_viewed'), 'Mais Vistos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_comments'), 'Mais comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'insufficient_privileges'), 'Você pode não ter privilégios suficientes para acessar esta página.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_edit_vdo'), 'Editar Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_video_details'), 'Detalhes do Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_title'), 'Título');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_desc'), 'Descrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat'), 'Categoria do Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat_msg'), 'Você pode selecionar até %s categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_br_opt'), 'Opções de Transmissão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_br_opt1'), 'Público - Compartilhe seu vídeo com todos! (recomendado)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_br_opt2'), 'Privado - Visível apenas para você e seus amigos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_add_eg'), 'Exemplo: Gronelândia de Londres, Sialkot Mubarak Pura');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_share_opt'), 'Opções de compartilhamento e privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_allow_comm'), 'Permitir comentários ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_dallow_comm'), 'Não permitir comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_allow_rating'), 'permitir avaliação neste vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_embedding'), 'Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_embed_opt1'), 'As pessoas podem reproduzir este vídeo em outros sites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_manage_vdeos'), 'Gerenciar Vídeos ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_status'), 'Situação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_view_vdos'), 'Ver vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_manage_members_title'), 'Gerenciar Membros ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_title'), 'Ativação do usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_actiavation_msg1'), 'Solicitar Código de Ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_code_tl'), 'Código de Ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_attach_video'), 'Anexar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_forgot_message'), 'Esqueci a senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_veri_code'), 'Código de Verificação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_recover'), 'Recuperar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_reset'), 'Redefinir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_inactive_msg'), 'Sua conta está inativa, por favor ative sua conta indo para a <a href=\"./activation.php\">página de ativação</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fav_videos'), 'Vídeos Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_channel_profiles'), 'Canal e Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_my_account'), 'Gerenciar minha conta ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_sent_box'), 'Meus itens enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_contacts'), 'Gerenciar Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_forgot_username'), 'Esqueceu o seu nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'all_fields_req'), 'Todos os campos são obrigatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_allowed_format'), 'Letras A-Z ou a-z, Números 0-9 e Sub-sublinhados _');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_confirm_pass'), 'Confirmar Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_date_of_birth'), 'Data de nascimento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_i_agree_to_the'), 'Concordo com os  <a href=\"%s\" target=\"_blank\">Termos de Serviço</a> e com a <a href=\"%s\" target=\"_blank\" >Política de Privacidade</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_change_pass'), 'Alterar senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_profile_settings'), 'Opções do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fname'), 'Nome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_lname'), 'Sobrenome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_relat_status'), 'Estado de relacionamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_about_me'), 'Sobre mim');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fav_movs_shows'), 'Filmes favoritos &amp; Séries');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fav_music'), 'Músicas Favoritas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fav_books'), 'Livros Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_user_avatar'), 'Avatar de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_change_email'), 'Alterar Email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_email_address'), 'Endereço de e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_new_email'), 'Novo e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_old_pass'), 'Senha Antiga');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_new_pass'), 'Nova senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_c_new_pass'), 'Confirmar Nova Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_doesnt_exist'), 'O usuário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_s_channel'), 'Canal de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_last_login'), 'Última Conexão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_add_comment'), 'Adicionar Comentário ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'menu_home'), 'Início');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'menu_inbox'), 'Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat_err2'), 'Você não pode selecionar mais de %d categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_already_logged'), 'Você já está logado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_not_logged_in'), 'Você não está logado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'invalid_user'), 'Usuário Inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat_err3'), 'Por favor, selecione pelo menos uma categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_thumb_changed'), 'Miniatura padrão do vídeo foi alterada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_vid_thumbs_msg'), 'Todas as miniaturas de vídeo foram carregadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_thumb_delete_msg'), 'A miniatura do vídeo foi excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_thumb_delete_err'), 'Não foi possível excluir a miniatura do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_comment_del_perm'), 'Você não tem permissão para excluir este comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_contains_disallow_err'), 'Nome de usuário contém caracteres não permitidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_cat_erro'), 'A categoria já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_cat_no_name_err'), 'Por favor, digite um nome para a categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_default_err'), 'O padrão não pode ser excluído, por favor, escolha outra categoria como «padrão» e apague esta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pic_upload_vali_err'), 'Por favor, carregue uma imagem válida de JPG, GIF ou PNG');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_dir_make_err'), 'Não foi possível criar o diretório de miniaturas da categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_set_default_ok'), 'A categoria foi definida como padrão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_thumb_removed_msg'), 'Miniaturas de vídeo removidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_files_removed_msg'), 'Os arquivos de vídeo foram removidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_log_delete_msg'), 'O registro de vídeo foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_multi_del_erro'), 'Os vídeos foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_fav_message'), 'Este %s foi adicionado aos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'obj_not_exists'), '%s não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'already_fav_message'), 'Este %s já foi adicionado aos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'obj_report_msg'), 'Este %s foi reportado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'obj_report_err'), 'Você já denunciou este %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_no_exist_wid_username'), '\'%s\' não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'share_video_no_user_err'), 'Por favor insira nomes de usuário ou e-mails para enviar este %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'today'), 'Hoje');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'yesterday'), 'Ontem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thisweek'), 'Esta Semana');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lastweek'), 'Última Semana');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thismonth'), 'Este Mês');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lastmonth'), 'Último Mês');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thisyear'), 'Este Ano');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lastyear'), 'Último Ano');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'favorites'), 'Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'alltime'), 'Desde o Inicio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'insufficient_privileges_loggin'), 'Você não pode acessar esta página, faça o login ou registre-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_dob'), 'Mostrar Data de Nascimento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_tags'), 'Tags do Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'online_status'), 'Situação do Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_profile'), 'Mostrar Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'allow_ratings'), 'Permitir avaliações de perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'postal_code'), 'Código postal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_date_provided'), 'Nenhuma data fornecida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'bad_date'), 'Nunca');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'users_videos'), 'Vídeos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_login_subscribe'), 'Por favor, faça o login para inscrever-se em %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'users_subscribers'), 'Inscritos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_subscriptions'), 'Inscrições de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_avatar_bg_update'), 'O avatar do usuário e o plano de fundo foram atualizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_email_confirm_email_err'), 'Confirmar e-mail incorreto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_change_msg'), 'E-mail foi alterado com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_edit_video'), 'Você não pode editar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove_fav_collection_confirm'), 'Tem certeza de que deseja remover esta coleção dos seus favoritos?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'fav_remove_msg'), '%s foi removido dos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unknown_favorite'), 'Favoritos desconhecidos %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_multi_del_fav_msg'), 'Os vídeos foram removidos dos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unknown_sender'), 'Remetente desconhecido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_message'), 'Por favor, digite algo para a mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unknown_reciever'), 'Destinatário desconhecido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_pm_exist'), 'A mensagem privada não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pm_sent_success'), 'Mensagem privada enviada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'msg_delete_inbox'), 'A mensagem foi excluída da caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'msg_delete_outbox'), 'A mensagem foi excluída da sua caixa de saída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'private_messags_deleted'), 'As mensagens privadas foram excluídas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'spe_users_by_comma'), 'separar nomes de usuários por vírgula');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_ban_msg'), 'Lista de bloqueio de usuários atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_user_ban_msg'), 'Nenhum usuário foi banido da sua conta!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thnx_sharing_msg'), 'Obrigado por compartilhar %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_comment_exists'), 'O comentário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_login_create_playlist'), 'Por favor, faça login para criar listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'play_list_with_this_name_arlready_exists'), 'Já existe uma lista de reprodução com o nome \'%s\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_playlist_name'), 'Digite o nome da lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'new_playlist_created'), 'Nova playlist criada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_not_exist'), 'A lista de reprodução não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_item_not_exist'), 'O item na lista de reprodução não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_item_delete'), 'O item da lista de reprodução foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'play_list_updated'), 'Lista de reprodução atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_hv_permission_del_playlist'), 'Você não tem permissão para excluir a lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_delete_msg'), 'Lista de reprodução excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_name'), 'Nome da Lista de Reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_new_playlist'), 'Adicionar Lista de Reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'this_already_exist_in_pl'), 'Este %s já existe na sua lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'edit_playlist'), 'Editar lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove_playlist_item_confirm'), 'Tem certeza de que deseja remover isto da sua lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove_playlist_confirm'), 'Tem certeza que deseja excluir esta lista de reprodução?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'avcode_incorrect'), 'Código de ativação incorreto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_playlist'), 'Gerenciar listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_notifications'), 'Minhas notificações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'users_contacts'), 'Contatos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type_flags_removed'), '%s sinalizações foram removidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'users'), 'Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'login_to_mark_as_spam'), 'Por favor, faça login para marcar como spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_own_commen_spam'), 'Você não pode marcar seu próprio comentário como spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'already_spammed_comment'), 'Você já marcou este comentário como spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'spam_comment_ok'), 'O comentário foi marcado como spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unable_find_download_file'), 'Não foi possível encontrar o arquivo de download');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_doesnt_exist'), 'A página não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pelase_select_img_file_for_vdo'), 'Por favor, selecione o arquivo de imagem para miniatura do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'new_mem_added'), 'Um novo membro foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'this_vdo_not_working'), 'Este vídeo pode não funcionar corretamente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_template_not_exist'), 'Modelo de email não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_subj_empty'), 'Assunto do email está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_msg_empty'), 'A mensagem de e-mail está vazia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_tpl_has_updated'), 'Modelo de E-mail foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_name_empty'), 'O nome da página está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_title_empty'), 'O título da página está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_content_empty'), 'O conteúdo da página estava vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'new_page_added_successfully'), 'Nova página foi adicionada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_updated'), 'A página foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_deleted'), 'Página excluída com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_activated'), 'A página foi ativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_deactivated'), 'A página foi desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_delete_this_page'), 'Você não pode excluir esta página');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_placement_err4'), 'O posicionamento não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thnx_for_voting'), 'Obrigado por votar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_hv_already_rated_vdo'), 'Você já avaliou este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_login_to_rate'), 'Por favor, inicie a sessão para avaliar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_not_subscribed'), 'Você não está inscrito');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_delete_this_user'), 'Você não pode excluir este usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_hv_perms'), 'Você não tem permissões suficientes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_subs_hv_been_removed'), 'As inscrições do usuário foram removidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_subsers_hv_removed'), 'Os inscritos do usuário foram removidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_already_sent_frend_request'), 'Você já enviou um pedido de amizade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friend_added'), 'O amigo foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friend_request_sent'), 'Pedido de amizade enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friend_confirm_error'), 'Ou o usuário não solicitou seu pedido de amizade ou você já o confirmou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friend_confirmed'), 'O amigo foi confirmado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friend_request_not_found'), 'Nenhum pedido de amizade encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_confirm_this_request'), 'Você não pode confirmar este pedido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friend_request_already_confirmed'), 'Pedido de amizade já confirmado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_no_in_contact_list'), 'O usuário não está na sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_removed_from_contact_list'), 'O usuário foi removido da sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cant_find_level'), 'Nível não encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_level_name'), 'Digite o nome do nível');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'level_updated'), 'O nível foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'level_del_sucess'), 'O nível de usuário foi excluído, todos os usuários deste nível foram transferidos para %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'level_not_deleteable'), 'Este nível não é deletável');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pass_mismatched'), 'Senhas não coincidem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_blocked'), 'O usuário foi bloqueado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_already_blocked'), 'O usuário já está bloqueado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_del_user'), 'Você não pode bloquear este usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_vids_hv_deleted'), 'Os vídeos do usuário foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_contacts_hv_removed'), 'Os contatos do usuário foram removidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'all_user_inbox_deleted'), 'Todas as mensagens da Caixa de Entrada do Usuário foram excluidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'all_user_sent_messages_deleted'), 'Todas as mensagens enviadas pelo usuário foram excluídas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pelase_enter_something_for_comment'), 'Por favor, digite algo na caixa de comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_your_name'), 'O nome não pode ser deixado em branco');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_your_email'), 'Por favor, insira o seu e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'template_activated'), 'O modelo foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'error_occured_changing_template'), 'Ocorreu um erro ao alterar o modelo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'language_does_not_exist'), 'O idioma não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_added'), 'Idioma adicionado com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'default_lang_del_error'), 'Este é o idioma padrão, selecione outro idioma como «padrão» e então exclua este pacote');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_deleted'), 'O pacote de idioma foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_name_empty'), 'O nome do idioma está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_code_empty'), 'O código do idioma estava vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_updated'), 'O idioma foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'player_activated'), 'O player foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'error_occured_while_activating_player'), 'Ocorreu um erro ao ativar o player');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_has_been_s'), 'O plug-in foi %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'plugin_uninstalled'), 'O plug-in foi desinstalado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'acitvation_html_message'), 'Digite seu nome de usuário e código de ativação para ativar sua conta. Não esqueça de checar a sua caixa de entrada para encontrar o código de ativação, caso não tenha recebido um, por favor solicite-o preenchendo o formulário a seguir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'acitvation_html_message2'), 'Por favor, digite seu endereço de e-mail para solicitar o código de ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'account_details'), 'Detalhes de conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_select_img_file'), 'Por favor, selecione arquivo de imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'or'), 'ou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pelase_enter_image_url'), 'Digite a URL da imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_bg'), 'Fundo do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete_this_img'), 'Excluir esta imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'current_email'), 'E-mail atual');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'confirm_new_email'), 'Confirme o novo email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_subs_found'), 'Nenhum inscrição encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'default'), 'Padrão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date_recorded_location'), 'Data de gravação &amp; localização');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_video'), 'Atualizar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remember_me'), 'Lembrar de mim');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'notifications'), 'Notificações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlists'), 'Listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'change_style_of_listing'), 'Alterar estilo da listagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_playlists'), 'Gerenciar listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_items'), 'Total de itens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'play_now'), 'REPRODUZA AGORA');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_video_in_playlist'), 'Esta playlist não tem nenhum vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view'), 'Ver');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_hv_fav_vids'), 'Você não tem nenhum vídeo favorito');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'private_messages'), 'Mensagens Privadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'new_private_msg'), 'Nova mensagem particular');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_success_usr_ok'), 'Apenas mais um passo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_success_usr_ok_description'), 'Você é apenas um passo para trás de se tornar um meme oficial do nosso site. Por favor, verifique seu e-mail, enviamos um e-mail de confirmação que contém um link de confirmação do nosso site. Por favor, clique nele para completar o seu registro.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_success_usr_emailverify'), '<h2 style=\"font-family:Arial,Verdana,sans-serif; margin:5px 5px 8px;\">Bem-vindo à nossa comunidade</h2>\n    \t<p style=\"margin:0px 5px; line-height:18px; font-size:11px;\">Seu e-mail foi confirmado, Por favor <strong><a href=\"%s\">clique aqui para fazer login</a></strong> e continuar como nosso membro registrado.</p>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_this'), 'Denunciar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_playlist'), 'Adicionar à lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_profile'), 'Ver Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subscribe'), 'Inscrever-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'more'), 'Mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'link_this_video'), 'Link para o vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'name'), 'Nome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_wont_display'), 'E-mail (não será exibido)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_login_to_comment'), 'Por favor, inicie a sessão para comentar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'spam'), 'Spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_comments'), 'Ninguém comentou sobre este %s ainda');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_video'), 'Assistir ao vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'info'), 'Informação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_logins'), 'Total de logins');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_hv_any_pm'), 'Não há mensagens para exibir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date_sent'), 'Data de envio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'quicklists'), 'Listas rápidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'change_avatar'), 'Alterar Avatar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'uploaded_videos'), 'Vídeos enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'time_ago'), '%s %s atrás');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'from_now'), '%s %s a partir de agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'private_video_error'), 'Este vídeo é privado, somente amigos que enviam podem ver este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_send_confirm'), 'Um e-mail foi enviado para o nosso administrador da Web, responderemos em breve');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'name_was_empty'), 'Nome está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'invalid_email'), 'E-mail inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pelase_enter_reason'), 'Motivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_something_for_message'), 'Por favor, digite algo na caixa de mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'file_size_exceeds'), 'Tamanho do arquivo excede \'%s kbs\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_rate_disabled'), 'A avaliação do vídeo está desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'viewed'), 'Visualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'top_rated'), 'Melhor avaliado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'searching_keyword_in_obj'), 'Pesquisando \'%s\' em %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_results_found'), 'Nenhum resultado encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_val_bw_min_max'), 'Por favor, digite um valor para \'%s\' entre \'%s\' e \'%s\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'inapp_content'), 'Conteúdo inadequado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'copyright_infring'), 'Violação de Direitos Autorais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'sexual_content'), 'Conteúdo Sexual');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'violence_replusive_content'), 'Violência ou conteúdo repugnante');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'disturbing'), 'Perturbador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'other'), 'Outros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friend_add_himself_error'), 'Você não pode se adicionar como amigo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'contact_us_msg'), 'Os seus comentários são importantes para nós e vamos avaliar eles o mais rapidamente possível. A informação solicitada neste formulário é voluntária. As informações estão a ser recolhidas para fornecer informações adicionais solicitadas por si e ajuda-nos a melhorar os nossos serviços.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'failed'), 'Falha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'more_fields'), 'Mais campos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remote_upload_file'), 'enviando arquivo <span id=\\\"remoteFileName\\\"></span>, aguarde...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remoteDownloadStatusDiv'), '<div class=\"remoteDownloadStatus\" id=\"remoteDownloadStatus\" >Baixado \n                <span id=\"status\">-- de --</span> @ \n                <span id=\"dspeed\">-- Kpbs</span>, Estimativa \n                <span id=\"eta\">--:--</span>, Tempo Gasto \n                <span id=\"time_took\">--:--</span>\n            </div>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_data_now'), 'Enviar Dados Agora!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'save_data'), 'Dados Salvos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'saving'), 'Salvando...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_file'), 'Enviar arquivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_video_button'), 'Explorar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_not_exist'), 'A foto não existe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_success_deleted'), 'A foto foi excluída com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cant_edit_photo'), 'Você não pode editar esta foto.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_hv_already_rated_photo'), 'Você já avaliou esta foto.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_rate_disabled'), 'Avaliação da foto está desativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'need_photo_details'), 'Precisa-se de detalhes da foto.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'embedding_is_disabled'), 'A incorporação foi desativada pelo usuário.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_activated'), 'A foto foi ativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_deactivated'), 'A foto foi desativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_featured'), 'A foto foi marcada como em destaque.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_unfeatured'), 'A foto não está mais em destaque.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_updated_successfully'), 'A foto foi atualizada com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'success_delete_file'), '%s arquivos foram excluídos com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_watermark_found'), 'Não foi possível encontrar arquivo de marca d\'água.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'watermark_updated'), 'Marca d\'água atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_png_watermark'), 'Por favor, envie arquivo PNG 24-bit.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_photos'), 'Você não tem nenhuma foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_fav_photos'), 'Você não tem nenhuma foto favorita');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_orphan_photos'), 'Gerenciar fotos órfãs');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_favorite_photos'), 'Gerenciar fotos favoritas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_photos'), 'Gerenciar fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_orphan_photos'), 'Você não tem nenhuma foto órfã');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'item_not_exist'), 'O item não existe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_not_exist'), 'A coleção não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'selected_collects_del'), 'As coleções selecionadas foram excluídas.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_collections'), 'Gerenciar coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_categories'), 'Gerenciar categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'flagged_collections'), 'Coleções sinalizadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_collection'), 'Criar coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'selected_items_removed'), '%s selecionados foram removidos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'edit_collection'), 'Editar coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_collection_items'), 'Gerenciar itens da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_favorite_collections'), 'Gerenciar coleções favoritas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_fav_collection_removed'), '%s coleções foram removidas dos favoritos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_photos_deleted'), '%s fotos foram excluídas com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_fav_photos_removed'), '%s fotos foram removidas dos favoritos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photos_upload'), 'Enviar foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_items_found_in_collect'), 'Nenhum item encontrado nesta coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_items'), 'Gerenciar Itens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_new_collection'), 'Adicionar nova coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_collection'), 'Atualizar coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_photo'), 'Atualizar foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_collection_found'), 'Você não tem nenhuma coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_title'), 'Título da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_caption'), 'Legenda da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection'), 'Coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo'), 'Foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video'), 'vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pic_allow_embed'), 'Ativar incorporação de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pic_dallow_embed'), 'Desativar incorporação de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pic_allow_rating'), 'Ativar avaliação de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pic_dallow_rating'), 'Desativar avaliação de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_more'), 'Adicionar mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_name_er'), 'O nome da coleção está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_descp_er'), 'A descrição da coleção está vazia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_tag_er'), 'As tags da coleção estão vazias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_cat_er'), 'Selecione a categoria de coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_borad_pub'), 'Tornar a coleção pública');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_allow_public_up'), 'Envio Público');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_pub_up_dallow'), 'Proibir que outros usuários adicionem itens.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_pub_up_allow'), 'Permitir que outros usuários adicionem itens.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_name'), 'Nome da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_description'), 'Descrição da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_tags'), 'Tags da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_category'), 'Categoria da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_added_msg'), 'A coleção foi adicionada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_not_exist'), 'A coleção não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photos'), 'Fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_all'), 'Todos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_remote_video_msg'), 'Enviar vídeos de outros sites ou servidores, simplesmente insira sua URL e clique em Enviar ou você pode inserir a URL do Youtube e clique em Resgatar do YouTube para enviar o vídeo diretamente do youtube sem inserir seus detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'browse_photos'), 'Explorar fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_is_saved_now'), 'A coleção de fotos foi salva');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_success_heading'), 'A coleção de fotos foi atualizada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'share_embed'), 'Compartilhado / Incorporado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'item_added_in_collection'), '%s foi adicionado com sucesso na coleção.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'object_exists_collection'), '%s já existe na coleção.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_broad_pri'), 'Tornar a coleção privada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_item_removed'), '%s foi removido da coleção.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_featured'), 'Coleção destacada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_unfeatured'), 'Coleção removida dos destaque.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_right_guide_photo'), '<strong>Importante: Não envie nenhuma foto que possa ser interpretada como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que estas fotos não violam os <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Termos de Uso do nosso site</span></a> e que você possui todos os direitos autorais destas fotos ou tem autorização para fazer o seu envio.</p>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_deactivated'), 'Coleção desativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_activated'), 'Coleção ativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_updated'), 'Coleção atualizada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cant_edit_collection'), 'Você não pode editar esta coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'object_not_in_collect'), '%s não existe nesta coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'object_does_not_exists'), '%s não existe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cant_perform_action_collect'), 'Você não pode executar tais ações nesta coleção.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_deleted'), 'Coleção excluída com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_not_exists'), 'A coleção não existe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_title_err'), 'Por favor, digite um título válido para a foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'this_has_set_profile_item'), 'Este %s foi definido como seu item de perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_item_removed'), 'O item do perfil foi removido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'make_profile_item'), 'Tornar item do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove_profile_item'), 'Remover item do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'content_type_empty'), 'O Tipo de Conteúdo está vazio. Por favor nos informe o tipo de conteúdo que você quer.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collections'), 'Coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'related_videos'), 'Vídeos Relacionados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_broadcast_unlisted'), 'Não listado (qualquer um com o link e/ou senha pode visualizar)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_link'), 'Link do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channel_settings'), 'Configurações do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'account_settings'), 'Configurações da conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'allow_subscription'), 'Permitir inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'allow_subscription_hint'), 'Permitir que membros se inscrevam no seu canal?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channel_title'), 'Título do Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channel_desc'), 'Descrição do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_my_friends'), 'Mostrar meus amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_my_videos'), 'Mostrar meus vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_my_photos'), 'Mostrar minhas fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_my_subscriptions'), 'Mostrar minhas inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_my_subscribers'), 'Mostrar meus inscritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_basic_info'), 'Informações básicas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_education_interests'), 'Educação, Hobbies, etc');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channel_profile_settings'), 'Configurações de canal e perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_my_collections'), 'Exibir as minhas coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unsubscribe'), 'Desinscrever-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_have_already_voted_channel'), 'Você já avaliou neste canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channel_rating_disabled'), 'A votação do canal está desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_activity'), 'Atividade do usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_view_profile'), 'Você não tem permissão para visualizar este canal :/');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'only_friends_view_channel'), 'Somente amigos de %s podem ver este canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_type'), 'Tipo da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_my_collection'), 'Adicionar isto à minha coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'block_users'), 'Bloquear usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cannot_rate_own_collection'), 'Você não pode avaliar sua própria coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_rating_not_allowed'), 'A classificação da coleção agora é permitida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_rate_own_video'), 'Você não pode avaliar seu próprio vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_rate_own_channel'), 'Você não pode avaliar seu próprio canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cannot_rate_own_photo'), 'Você não pode avaliar sua própria foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cant_pm_banned_user'), 'Você não pode enviar mensagens privadas para %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_are_not_allowed_to_view_user_channel'), 'Você não tem permissão para ver o canal de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_send_pm_yourself'), 'Você não pode enviar mensagens privadas para si mesmo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_password'), 'Senha do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'set_video_password'), 'Digite a senha de vídeo para torná-lo \"protegido por senha\"');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_pass_protected'), 'Este vídeo é protegido por senha, você deve inserir uma senha válida para ver este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_video_password'), 'Por favor, insira uma senha válida para assistir a este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_is_password_protected'), '%s está protegido por senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'invalid_video_password'), 'Senha do vídeo inválida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'logged_users_only'), 'Logado apenas (somente usuários logados podem assistir)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'specify_video_users'), 'Digite um nome de usuário que pode assistir a este vídeo, separado por vírgula');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_users'), 'Usuários do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'not_logged_video_error'), 'Você não pode assistir a este vídeo porque não está logado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subs_email_sent_to_users'), 'E-mail de inscrição foi enviado para %s usuário%s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_uploaded_new_photo'), '%s enviou uma nova foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_joined_us'), '%s juntou-se a %s , disse olá para %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_uploaded_new_video'), '%s enviou um novo vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'watch_video'), 'Assista ao vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_photo'), 'Ver foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_is_now_friend_with_other'), '%s e %s agora são amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_created_new_collection'), '%s criou uma nova coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_collection'), 'Ver a coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_favorited_video'), '%s adicionou um vídeo aos favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_activity'), '%s não possui atividades recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_sub_yourself'), 'Você não pode se inscrever em seu proprio canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_my_album'), 'Gerenciar meu álbum');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_permission_to_update_this_video'), 'Você não tem permissão para atualizar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'share_this_type'), 'Compartilhar este %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'seperate_usernames_with_comma'), 'Separe nomes de usuário com vírgula');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'album_privacy_updated'), 'A privacidade do álbum foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_fav_collections'), 'Você não tem nenhuma coleção favorita');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remote_upload_example'), 'ex. http://sitedeenvio.com/exemplo.flv http://www.youtube.com/watch?v=QfRHfquzM0');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_blocked_user_list'), 'Atualizar lista de usuários bloqueados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_user_associated_with_email'), 'Nenhum usuário está associado a este endereço de e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pass_changed_success'), '<div class=\"simple_container\">\n    \t<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">A senha foi alterada, por favor, verifique seu e-mail</h2>     \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 11px;\">Sua senha foi alterada com sucesso, por favor, verifique sua caixa de entrada para converir a senha recém-gerada, assim que você acessar a sua conta, altere a sua senha clicando em Mudar a senha.</p>\n </div>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_as_friend'), 'Adicionar como Amigo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_item_was_selected_to_delete'), 'Nenhum item foi selecionado para excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_items_have_been_removed'), 'Os itens da lista de reprodução foram removidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_playlist_was_selected_to_delete'), 'Selecione uma lista de reprodução primeiro.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'featured_videos'), 'Vídeos em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'recent_videos'), 'Vídeos recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'featured_users'), 'Usuários em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'top_collections'), 'Top coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'top_playlists'), 'Top Playlists');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'load_more'), 'Carregar mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_playlists'), 'Nenhuma lista de reprodução encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'featured_photos'), 'Fotos em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_channel_found'), 'Nenhum canal encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to'), 'Adicionar a');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'player_size'), 'Tamanho do Player');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'small'), 'Pequeno');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'medium'), 'Médio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'large'), 'Grande');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'iframe'), 'Iframe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'embed_object'), 'Objeto Incorporado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_my_favorites'), 'Adicionar aos favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_select_playlist'), 'Por favor, selecione o nome da lista de reprodução a seguir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_new_playlist'), 'Criar uma nova lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'select_playlist'), 'Selecionar da lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_video'), 'Denunciar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_text'), 'Por favor, selecione a categoria que reflete mais de perto sua preocupação com o vídeo, para que possamos revê-lo e determinar se ele viola as nossas Diretrizes Comunitárias ou se não é apropriado para todos os telespectadores. Abusar deste recurso é também uma violação das Diretrizes Comunitárias, por isso não o faça. ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comment_as'), 'Comente como');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'more_replies'), 'Mais respostas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_description'), 'Descrição da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'flag'), 'Sinalizar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_cover'), 'Atualizar capa');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unfriend'), 'Desfazer Amizade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'accept_request'), 'Aceitar solicitação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'online'), 'Online');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'offline'), 'Offline');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_video'), 'Enviar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_photo'), 'Enviar foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'admin_area'), 'Área do Administrador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_channels'), 'Ver canais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_channel'), 'Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_videos'), 'Gerenciar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cancel_request'), 'Cancelar solicitação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_featured_videos_found'), 'Nenhum vídeo em destaque encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_recent_videos_found'), 'Nenhum vídeo recente encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_collection_found_alert'), 'Nenhuma coleção encontrada! Você deve criar uma coleção antes de enviar qualquer foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'select_collection_upload'), 'Selecionar coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_new_collection_btn'), 'Criar uma nova coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_upload_tab'), 'Enviar foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_videos_found'), 'Nenhum vídeo encontrado!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'Latest_Videos'), 'Vídeos mais recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'videos_details'), 'Detalhes dos Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'option'), 'Opção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'flagged_obj'), 'Objetos Sinalizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'watched'), 'Assistido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'since'), 'desde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'last_Login'), 'Última Conexão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_friends_in_list'), 'Você não tem amigos na sua lista');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_pending_friend'), 'Nenhum pedido de amizade pendente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hometown'), 'Cidade natal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'city'), 'Cidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'schools'), 'Escolas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'occupation'), 'Ocupação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_videos'), 'Você não tem vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'write_msg'), 'Escrever mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'content'), 'Conteúdo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_video'), 'Nenhum vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'back_to_collection'), 'Voltar para Coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'long_txt'), 'Todas as fotos enviadas são dependentes de suas coleções/álbuns. Ao remover alguma foto de coleção/álbum, isto não vai excluir a foto de forma permanente. Isto irá mover a foto daqui. Você também pode usar isto para tornar suas fotos privadas. O link direto está disponível para compartilhamento com seus amigos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'make_my_album'), 'Criar meu álbum');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'public'), 'Público');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'private'), 'Privado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'for_friends'), 'Para Amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'submit_now'), 'Enviar Agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'drag_drop'), 'Arraste &amp; solte arquivos aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_more_videos'), 'Envie mais vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'selected_files'), 'Arquivos Selecionados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_videos'), 'Vídeos da lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'popular_videos'), 'Vídeos populares');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'uploading'), 'Enviando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'select_photos'), 'Selecionar fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'uploading_in_progress'), 'Envio em andamento ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'complete_of_photo'), 'Completo da Foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_more_photos'), 'Envie mais fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'save_details'), 'Salvar Detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'related_photos'), 'Fotos Relacionadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_photos_found'), 'Nenhuma foto encontrada !');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'search_keyword_feed'), 'Pesquisar palavra-chave aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'contacts_manager'), 'Gerenciador de Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'weak_pass'), 'A senha é fraca');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_account_msg'), 'Junte-se para começar a compartilhar vídeos e fotos. Leva apenas alguns minutos para criar a sua conta gratuita');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'get_your_account'), 'Criar Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type_password_here'), 'Digite a senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type_username_here'), 'Digite um nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'terms_of_service'), 'Termos de Serviço');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_vid_thumb_msg'), 'Miniaturas carregadas com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'watch'), 'Assistir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'successful'), 'Sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'processing'), 'Processando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'creating_collection_is_disabled'), 'A criação de coleção foi desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'creating_playlist_is_disabled'), 'A criação de lista de reprodução está desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'inactive'), 'Inativo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_actions'), 'Ações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_ph'), 'Ver');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'edit_ph'), 'Editar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete_ph'), 'Excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_ph'), 'Título');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_edit_playlist'), 'Ver/Editar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_playlist_found'), 'Nenhuma lista de reprodução encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_owner'), 'Dono');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_privacy'), 'Privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_collection'), 'Adicionar à coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_added_to_playlist'), 'Este vídeo foi adicionado à lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_usr'), 'Denunciar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'un_reg_user'), 'Usuário não registrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_playlists'), 'Minhas listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'website_offline'), 'ATENÇÃO: ESTE SITE ESTÁ NO MODO OFFLINE');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'loading'), 'Carregando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hour'), 'hora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hours'), 'horas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'day'), 'dia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'days'), 'dias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'week'), 'semana');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'weeks'), 'semanas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'month'), 'mês');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'months'), 'meses');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'year'), 'ano');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'years'), 'anos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'decade'), 'década');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'decades'), 'décadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'your_name'), 'Seu nome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'your_email'), 'Seu e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type_comment_box'), 'Por favor, digite algo na caixa de comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'guest'), 'Visitante');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_comment_added'), 'Nenhum comentário adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'register_min_age_request'), 'Você deve ter pelo menos %s anos de idade para registrar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'select_category'), 'Por favor, selecione sua categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'custom'), 'Personalizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_playlist_exists'), 'Não existe nenhuma lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'edit'), 'Editar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'create_new_account'), 'Criar uma nova conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'search_too_short'), 'Consulta de pesquisa %s é muito curta. Abra!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_allow_comments'), 'Permitir comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_allow_rating'), 'Permitir avaliação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_description'), 'Descrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlists_have_been_removed'), 'As Listas de reprodução foram removidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'confirm_collection_delete'), 'Você realmente quer excluir esta coleção ?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_select_collection'), 'Por favor, selecione o nome da coleção a seguir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'resolution'), 'Resolução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'filesize'), 'Tamanho do arquivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'empty_next'), 'A lista de reprodução atingiu o seu limite!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_items'), 'Não há itens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_recover_user'), 'Esqueceu o Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'reply_to'), 'Responder a');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mail_type'), 'Tipo de email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'host'), 'Servidor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'port'), 'Porta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user'), 'Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'auth'), 'Autenticação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mail_not_send'), 'Não foi possível enviar o e-mail <strong>%s</strong>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mail_send'), 'E-mail enviado com sucesso para <strong>%s</strong>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title'), 'Título');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_comments'), 'Mostrar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hide_comments'), 'Ocultar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'description'), 'Descrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'users_categories'), 'Categorias de Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'popular_users'), 'Usuários Populares');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channel'), 'Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'confirm_del_photo'), 'Você tem certeza que deseja excluir esta foto?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signups'), 'Cadastros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'active_users'), 'Usuários Ativos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_name_invalid_len'), 'Comprimento do usuário é inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'username_spaces'), 'O nome de usuário não pode conter espaços');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_caption_err'), 'Digite a descrição da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_collection_err'), 'Você deve especificar uma coleção para esta foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'details'), 'Detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'technical_error'), 'Ocorreu um erro técnico!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'inserted'), 'Inserido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'castable_status_fixed'), 'O Estado de Transmitido de %s foi corrigido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'castable_status_failed'), '%s não pode ser transmitido corretamente porque tem %s canais de áudio, por favor, reconverta o vídeo com opção chromecast ativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'castable_status_check'), 'Verificar Estado de Transmitivel');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'castable'), 'Transmitível');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'non_castable'), 'Não-Transmissível');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'videos_manager'), 'Gerenciador de vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_bits_color'), 'Atualizar cores de bits');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'bits_color'), 'cores dos bits');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'bits_color_compatibility'), 'O formato de vídeo torna isso impossível de reproduzir em alguns navegadores como Firefox, Safari, ...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'player_logo_reset'), 'O logo do player foi redefinido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'player_settings_updated'), 'As configurações do player foram atualizadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'player_settings'), 'Configurações do player');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'quality'), 'Qualidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'error_occured'), 'Ops... Algo de errado aconteceu...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'error_file_download'), 'Falha ao obter o arquivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'dashboard_update_status'), 'Estado da Atualização');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'dashboard_changelogs'), 'Registro de alterações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'dashboard_php_config_allow_url_fopen'), 'Por favor, habilite \'allow_url_fopen\' para beneficiar o relatório de alterações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_error_email_unauthorized'), 'E-mail não permitido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_detail_saved'), 'Os detalhes do vídeo foram salvos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_subtitles_deleted'), 'As legendas do vídeo foram excluídas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_no_parent'), 'Nenhum progenitor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_parent'), 'Coleção parental');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_upload_video_limits'), 'Cada vídeo não pode exceder %s MB de tamanho ou %s minutos de duração e deve estar em um formato de vídeo comum');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_upload_video_select'), ' Selecionar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'page_upload_photo_limits'), 'Cada foto não pode exceder %s MB de tamanho e deve estar em um formato de imagem comum');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_resolution_auto'), 'Automático');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_thumbs_regenerated'), 'As miniaturas do vídeo foram regeneradas com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_allow_comment_vote'), 'Permitir votos nos comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'code'), 'Código');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_tool'), 'Ferramentas Administrativas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'launch'), 'Iniciar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'stop'), 'Parar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'in_progress'), 'Em progresso', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'ready'), 'Pronto', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'stopping'), 'Parando', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'generate_missing_thumbs_label'), 'Gerar miniaturas faltantes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'generate_missing_thumbs_description'), 'Gerar miniaturas para os vídeos sem uma miniatura', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_castable_status_label'), 'Atualizar status de vídeos transmissíveis', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_castable_status_description'), 'Atualize o status de todos os vídeos que podem ser transmitidos com base nos arquivos de vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_bits_color_label'), 'Atualizar status de codificação de cores dos vídeos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_bits_color_description'), 'Atualize o status de codificação de cores de todos os vídeos, com base nos arquivos de vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_videos_duration_label'), 'Atualizar as durações dos vídeos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_videos_duration_description'), 'Atualize todas as durações dos vídeos, com base nos arquivos de vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'need_db_upgrade'), 'Você tem <b>%s</b> arquivos para executar para poder atualizar seu banco de dados. Você pode usar este link a seguir: ', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'db_up_to_date'), 'Seu banco de dados está atualizado', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_database_version_label'), 'Atualizar seu banco de dados para a versão atual', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_database_version_description'), 'Execute todos os arquivos SQL necessários para atualizar o banco de dados', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_version'), 'Seu ClipBucket usa o antigo sistema de atualização de banco de dados. Execute todos os arquivos de migração SQL para a versão 5.3.0 antes de continuar.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'select_version'), 'Por favor, selecione sua versão atual e a revisão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'version'), 'versão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'revision'), 'revisão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'system_info'), 'Informações do Sistema', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'hosting'), 'Hospedagem', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_ffmpeg'), 'é usado para converter vídeos de diferentes versões para FLV, MP4 e muitos outros formatos.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_box'), 'Caixa de Ferramentas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_php_cli'), 'é usado para realizar a conversão de vídeo em um processo em segundo plano.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_media_info'), 'fornece informações técnicas e de marcação sobre um arquivo de vídeo ou áudio.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_ffprobe'), 'é uma extensão do FFMPEG usada para obter informações do arquivo de mídia', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_php_web'), 'é usado para exibir esta página', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'must_be_least'), 'deve ser pelo menos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'php_cli_not_found'), 'PHP CLI não está configurado corretamente', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cache'), 'cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_cache'), 'Ativar cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_cache_authentification'), 'Ativar autenticação de cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_cache_label'), 'Redefinir Cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_cache_description'), 'Limpar todas as entradas do cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nb_files'), 'Numero de arquivos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_file_management'), 'Gerenciamento de arquivos de vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_delete_video_file'), 'Tem certeza de que deseja excluir a resolução %sp ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_video_log_label'), 'Deletar logs de conversão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_video_log_description'), 'Deletar o log de conversão de vídeos convertidos com sucesso', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_conversion_log'), 'Nenhum arquivo de log de conversão dísponivel', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'watch_conversion_log'), 'Ver o log de conversão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'conversion_log'), 'Log de conversão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'open_debug'), 'Solicitações SQL', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'select_queries'), 'Selecionar Consultas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_queries'), 'Atualizar Consultas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'delete_queries'), 'Atualizar Consultas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'insert_queries'), 'Atualizar Consultas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'execute_queries'), 'Atualizar Consultas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'expensive_query'), 'Consultas Caras', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cheapest_query'), 'Consultas Baratas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'overall_stats'), 'Estatísticas Gerais', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'base_directory'), 'Diretório base', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'queries'), 'Consultas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'all_queries'), 'Todas as consultas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'total_db_queries'), 'Total de Consultas em BD', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'total_cache_queries'), 'Total de Consultas em Cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'total_execution_time'), 'Tempo Total de Execução', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'total_memory_used'), 'Total de Memória Usada', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'memory_usage'), 'Uso de Memória', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'everything'), 'Tudo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'display'), 'Exibir', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'disable_email'), 'Desativar Emails', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'number'), 'Número', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_delete_subtitle_file'), 'Tem certeza de que deseja excluir a faixa de legenda n°%s ?', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_subtitle_management'), 'Gerenciar legendas do vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_subtitles_deleted_num'), 'A faixa de legenda n°%s foi excluída', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'waiting'), 'Aguardando', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_country'), 'Ativar seleção de País', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_gender'), 'Ativar seleção de Sexo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_category'), 'Ativar seleção de Categoria de Usuário', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_upload_disabled'), 'O Envio de Vídeos foi desativado', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_compatible'), 'Plugin compativel com a versão atual do Clipbucket', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'plugin_not_compatible'), 'Plugin não compativel com a versão atual do Clipbucket', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_orphan_files_label'), 'Excluir Arquivos Orfãos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_orphan_files_description'), 'Excluir arquivos de vídeos, legendas, miniaturas e arquivos de logs que não estejam relacionados a entradas no banco de dados', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'lang_restored'), 'O idioma %s foi restaurado com sucesso.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'language_name'), 'Nome do Idioma', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'restore_language'), 'Restaurar idioma', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'restore'), 'Restaurar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'of'), 'de', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm'), 'Confirmar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'uploaded'), 'Enviado', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'photo_tags'), 'Tags de Fotos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_is'), 'A Coleção é %s');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'not_found'), 'Não encontrado', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'age_restriction'), 'Restrição de Idade', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_age_restriction'), 'Deixe o campo vazio para nenhuma restrição. Caso contrário, insira a idade mínima para acessar o conteúdo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'access_forbidden_under_age'), 'Acesso restrito abaixo de %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_age_restriction'), 'Habilitar restrição de idade nas mídias', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_user_dob_edition'), 'Permitir edição da data de nascimento', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'user_dob_edition_disabled'), 'A edição da data de nascimento está desativada', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_blur_restricted_content'), 'Desfocar conteúdos restritos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_enable_blur_restricted_content'), 'Quando ativado, os conteúdos restritos ficam visíveis, mas desfocados; quando não, os conteúdos restritos ficam ocultos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_global_age_restriction'), 'Ativar pop-in global de restrição de idade', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_age_restriction'), 'Você não tem idade suficiente para acessar este conteúdo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_age_restriction_save'), 'A idade mínima exigida deve ser entre 1 e 99 anos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'age_verification'), 'Verificação de idade', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'age_verification_text'), 'Este site contém materiais com restrição de idade. Ao entrar, você afirma que tem pelo menos %s anos de idade.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'disclaimer_older'), 'Tenho %s ou mais - Enter', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'disclaimer_return'), 'Tenho menos de %s - Sair', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tips_enable_global_age_restriction'), 'Cadastro com uma idade base minima', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'edition_min_age_request'), 'A idade não pode ser inferior a %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_quicklist'), 'Ativar lista rápida', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_hide_empty_collection'), 'Ocultar coleções vazias', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'comment_disabled_for'), 'Os comentários estão desativados para este %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'dev_mode'), 'Modo de Desenvolvimento', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'dev'), 'dev', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'discord_error_log'), 'Habilitar log de erros do Discord', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'discord_webhook_url'), 'URL do Webhook do Discord', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'discord_webhook_url_invalid'), 'O URL do webhook do Discord é inválido', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_sitemap'), 'Ativar mapa do site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'category_type_unknown'), 'Tipo de categoria desconhecido: %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_setting'), 'Configurações do Administrador', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'site_setting'), 'Configurações do Site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_username'), 'Usuário do Administrador', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_password'), 'Senha do Administrador', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_email'), 'Email do Administrador', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'save_continue'), 'Salvar e Continuar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'hint_admin_username'), 'O nome de usuário pode ter apenas caracteres alfanuméricos, sublinhados e hifens', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'hint_admin_email'), 'Verifique seu endereço de e-mail antes de continuar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_install_info'), 'Todas as etapas principais foram concluídas, agora informe o nome de usuário e a senha do seu usuário como administrador, por padrão, seu nome de usuário é: <strong>admin</strong> | A senha é: <strong>admin</strong>', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'generate'), 'Gerar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'current'), 'Atual', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_configuration'), 'Configurações básicas do site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_configuration_info'), 'Aqui você pode definir as configurações básicas do seu site, você pode alterá-las posteriormente acessando Área administrativa > Configurações do site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_title'), 'Nome do Site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_title_hint'), 'É o título do seu site E você pode ALTERÁ-LO NA área ADMIN', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_slogan'), 'Slogan do Site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_slogan_hint'), 'É o slogan do seu site, você pode alterá-lo na área administrativa', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_url'), 'URL do Site', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'website_url_hint'), 'Sem barra final', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'agreement'), 'Acordo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'pre_check'), 'Pré-verificação', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'permission'), 'Permissões', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'database'), 'Base de Dados', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'data_import'), 'Importação de Dados', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'finish'), 'Terminar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'continue_admin_area'), 'Continuar para a Área Administrativa', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'continue_to'), 'Continuar para', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'successful_install'), 'foi instalado com sucesso!', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'default_language'), 'Idioma Padrão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_server_config'), 'Você deve atualizar as <strong>"Configurações do Servidor"</strong>. <a href="%s">Clique aqui</a> para mais detalhes.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'not_required_version'), 'A versão atual do %s é <strong>%s</strong>, a versão <strong>%s</strong> é a minima requerida', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'dob_required'), 'A data de nascimento é obrigatória', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'completed'), 'Concluído', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'error_allow_photo_types'), 'Somente os seguintes formatos de imagem são permitidos: %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'mysql_client'), 'Cliente MySQL', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'mysql_server'), 'Servidor MySQL', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_git_path'), 'Caminho Git', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'core_upgrade_avaible'), 'Atualização de núcleo disponível, clique aqui para atualizar: ', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_core_label'), 'Atualização de Núcleo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_core_description'), 'Use o GIT para reverter todas as alterações de núcleo e atualizar para a revisão mais recente', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'core_up_to_date'), 'Seu núcleo está atualizado', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_session_table_label'), 'Limpar tabela de sessão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'clean_session_table_description'), 'Excluir entradas de sessões na tabela com mais de um mês', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_recalcul_video_file_label'), 'Atualizar listagem de arquivos de vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_recalcul_video_file_description'), 'Atualizar a lista de arquivos de todos os vídeos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'recreate_thumb_label'), 'Recriar miniaturas de fotos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'recreate_thumb_description'), 'Recrie todos as miniaturas das fotos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_logs'), 'Nenhum registro para exibir', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'show_log'), 'Mostrar últimos registros', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_started'), 'Ferramenta iniciada', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_stopped'), 'Ferramenta parada', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_ended'), 'Ferramenta encerrada', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_tmdb'), 'Habilitar TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tmdb_token'), 'Token de autenticação TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tmdb_token_check'), 'Verifique o token TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'get_data_tmdb'), 'Obtenha informações do The Movie DataBase', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'release_date'), 'Data de Lançamento', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'import'), 'Importar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'actors'), 'Atrores', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'producer'), 'Produtor', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'crew'), 'Equipe', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'genre'), 'Gênero', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'executive_producer'), 'Produtor Executivo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'director'), 'Diretor', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_genre'), 'Obtenha o gênero do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_actors'), 'Obtenha atores do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_producer'), 'Obtenha o produtor do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_executive_producer'), 'Obtenha produtor executivo do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_director'), 'Obter diretor do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_crew'), 'Obtenha equipe do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_poster'), 'Obtenha pôster do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_release_date'), 'Obtenha a data de lançamento do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_title'), 'Obtenha o título do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_description'), 'Obtenha a descrição do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tmdb_search'), 'Pesquisar no The Movie Database', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'movie_infos'), 'Info do Filme', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_video_poster'), 'Ativar pôster', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_enable_video_backdrop'), 'Ativar cenário', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_age_restriction'), 'Obtenha restrição de idade do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_tmdb_get_backdrop'), 'Obtenha o cenário do TMDB', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'sort_by'), 'Classificar por %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'backdrop'), 'Cenário', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'poster'), 'Pôster', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'thumbnail'), 'Miniatura', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'default_x'), 'Padrão %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'option_require_x_enabled'), 'Esta opção requer que \'%s\' esteja habilitado', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'select_as_default_x'), 'Selecione como padrão %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_x_field'), 'Habilitar o campo %s', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_category'), 'Atualizar Categoria', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'add_new_category'), 'Adicionar Nova Categoria', @language_id);