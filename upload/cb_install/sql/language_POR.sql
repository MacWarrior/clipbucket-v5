INSERT INTO `{tbl_prefix}languages` (`language_name`, `language_active`, `language_default`, `language_code`)
VALUES ('Portuguesa', 'yes', 'no', 'pt-BR');

SET @language_id = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_name LIKE 'Portuguesa');

INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_name_error'), 'Por favor, insira um nome para o anúncio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_code_error'), 'Erro : Por favor, digite o código para o anúncio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_exists_error1'), 'O anúncio não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_exists_error2'), 'Erro: Anúncio com este nome já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_add_msg'), 'Anúncio adicionado com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_msg'), 'O anúncio foi ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_update_msg'), 'O anúncio foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_del_msg'), 'Anúncio foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_deactive'), 'Desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_active'), 'Ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_placment_delete_msg'), 'O posicionamento foi removido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_placement_err1'), 'O posicionamento já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_placement_err2'), 'Por favor, digite um nome para o posicionamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_placement_err3'), 'Por favor, digite um código para o posicionamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_placement_msg'), 'O posicionamento foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cat_img_error'), 'Por favor, carregue apenas imagens JPEG, GIF ou PNG');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cat_exist_error'), 'A categoria não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cat_add_msg'), 'Categoria foi adicionada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cat_update_msg'), 'A categoria foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_err'), 'O Grupo Não Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_fr_msg'), 'O grupo foi definido como destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_fr_msg1'), 'Os Grupos Selecionados Foram Removidos da Lista de Destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_ac_msg'), 'Os Grupos Selecionados Foram Ativados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_dac_msg'), 'Os Grupos Selecionados Foram Desativados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_del_msg'), 'O grupo foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'editor_pic_up'), 'O vídeo foi movido para cima');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'editor_pic_down'), 'Vídeo foi movido para baixo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_install_msg'), 'O plugin foi instalado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_no_file_err'), 'Nenhum arquivo encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_file_detail_err'), 'Detalhes do plugin desconhecido encontrados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_installed_err'), 'Plugin já instalado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_no_install_err'), 'O plugin não está instalado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_name_error'), 'Digite o nome do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_name_error1'), 'Nome de grupo já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_des_error'), 'Por favor, insira uma Pequena Descrição para o Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tags_error'), 'Por favor, digite Tags para o Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_url_error'), 'Por favor, insira um URL válido para o Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_url_error1'), 'Por favor, insira um nome de URL válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_url_error2'), 'URL de grupo já existe, por favor escolha uma URL diferente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tpc_error'), 'Por favor, insira um tópico para adicionar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_comment_error'), 'Você deve digitar um comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_join_error'), 'Você já entrou neste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_prvt_error'), 'Este grupo é privado, faça o login para visualizar este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_inact_error'), 'Este grupo está inativo, por favor contate o administrador para este problema');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_join_error1'), 'Você ainda não se juntou a este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_exist_error'), 'Desculpe, o Grupo não Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tpc_error1'), 'Este tópico não foi aprovado pelo proprietário do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_cat_error'), 'Selecione uma categoria para o seu grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tpc_error2'), 'Por favor, insira um tópico para adicionar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tpc_error3'), 'Seu tópico requer aprovação do proprietário deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tpc_msg'), 'O tópico foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_comment_msg'), 'O comentário foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_vdo_msg'), 'Vídeos excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_vdo_msg1'), 'Vídeos adicionados com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_vdo_msg2'), 'Os vídeos foram aprovados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_mem_msg'), 'O membro foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_mem_msg1'), 'O membro foi aprovado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_inv_msg'), 'Seu convite foi enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tpc_msg1'), 'O tópico foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tpc_msg2'), 'Tópico foi aprovado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_fr_msg2'), 'O grupo foi removido da lista de destaques');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_inv_msg1'), 'Convidou você para se juntar ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_av_msg'), 'O grupo foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_da_msg'), 'O grupo foi desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_post_msg'), 'A Postagem foi excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_update_msg'), 'O grupo foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_owner_err'), 'Apenas o proprietário pode adicionar vídeos a este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_owner_err1'), 'Você não é dono deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_owner_err2'), 'Você é dono deste grupo. Você não pode sair do seu grupo.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_prvt_err1'), 'Este grupo é privado, você precisa de convite de seu proprietário para entrar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_rmv_msg'), 'Os Grupos Selecionados foram Removidos da Sua Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tpc_err4'), 'Desculpe, Tópico não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_title_topic'), 'Grupos - Tópico - ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_add_title'), '- Adicionar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_sadmin_err'), 'Você não pode deixar o nome de usuário do SuperAdmin em branco');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cpass_err'), 'A senha de confirmação não corresponde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pass_err'), 'A senha antiga está incorreta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_email_err'), 'Por favor, forneça um endereço de e-mail válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cpass_err1'), 'Confirmação de senha incorreta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pass_err1'), 'A senha está incorreta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cmt_err'), 'Você precisa fazer login primeiro para comentar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cmt_err1'), 'Por favor, digite algo na Caixa de Comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cmt_err2'), 'Você não pode comentar em seu vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cmt_err3'), 'Você já postou um comentário neste canal.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cmt_err4'), 'O comentário foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cmt_del_msg'), 'O comentário foi excluido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cmt_del_err'), 'Ocorreu um erro ao remover o comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cnt_err'), 'Você não pode se adicionar como um contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cnt_err1'), 'Você já adicionou este usuário à sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_sub_err'), 'Você já está inscrito em %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_exist_err'), 'O usuário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_ccode_err'), 'O código de verificação inserido está errado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_exist_err1'), 'Desculpe, nenhum usuário existe com este e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_exist_err2'), 'Desculpe, o usuário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_uname_err'), 'Nome de usuário está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_uname_err2'), 'Nome de usuário já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pass_err2'), 'A senha está vazia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_email_err1'), 'E-mail está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_email_err2'), 'Por favor, insira um endereço de e-mail válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_email_err3'), 'O endereço de e-mail já está em uso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pcode_err'), 'Códigos postais contêm apenas números');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_fname_err'), 'O nome está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_lname_err'), 'O último nome está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_uname_err3'), 'Nome de usuário contém caracteres não permitidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pass_err3'), 'Senhas não Correspondentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_dob_err'), 'Selecione a data de nascimento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_ament_err'), 'Desculpe, você precisa concordar com os termos de uso e política de privacidade para criar uma conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_reg_err'), 'Desculpe, os registros não estão permitidos temporariamente. Por favor, tente novamente mais tarde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_ban_err'), 'Conta de usuário banida, entre em contato com o administrador do site');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_login_err'), 'Nome de usuário e senha não correspondem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_sadmin_msg'), 'Super Administrador foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pass_msg'), 'Sua senha foi alterada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_cnt_msg'), 'Este usuário foi adicionado à sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_sub_msg'), 'Você agora é um inscrito de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_uname_email_msg'), 'Enviamos um e-mail para você contendo seu nome de usuário, por favor verifique-o');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_rpass_email_msg'), 'Um e-mail foi enviado para você. Siga as instruções lá para redefinir sua senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pass_email_msg'), 'A senha foi alterada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_email_msg'), 'As configurações de e-mail foram atualizadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_del_msg'), 'O usuário foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_dels_msg'), 'Os usuários selecionados foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_ac_msg'), 'O usuário foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_dac_msg'), 'O usuário foi desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_mem_ac'), 'Os Membros Selecionados Foram Ativados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_mems_ac'), 'Os membros selecionados foram desativados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_fr_msg'), 'O usuário foi definido como um membro em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_ufr_msg'), 'O Usuário foi removido dos usuários em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_frs_msg'), 'Os usuários selecionados foram definidos como em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_ufrs_msg'), 'Os usuários selecionados foram removidos da lista em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_uban_msg'), 'O usuário foi banido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_uuban_msg'), 'O usuário foi desbanido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_ubans_msg'), 'Os membros selecionados foram banidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_uubans_msg'), 'Os membros selecionados foram desbanidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pass_reset_conf'), 'Confirmação para Redefinição de Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_dear_user'), 'Caro Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pass_reset_msg'), 'Você solicitou uma redefinição de senha, siga o link para redefinir sua senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_rpass_msg'), 'A senha foi redefinida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_rpass_req_msg'), 'Você solicitou uma redefinição de senha, aqui está a sua nova senha: ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_uname_req_msg'), 'Você solicitou a Recuperação do Seu Nome de Usuário, Aqui está seu Nome de Usuário: ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_uname_recovery'), 'E-mail de recuperação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_add_succ_msg'), 'O usuário foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_upd_succ_msg'), 'O usuário foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_activation_msg'), 'Sua conta foi ativada. Agora você pode fazer login em sua conta e enviar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_activation_err'), 'Este usuário já está ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_activation_em_msg'), 'Enviamos um e-mail contendo o seu código de ativação. Por favor, verifique sua caixa de correio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_activation_em_err'), 'O e-mail não existe ou o usuário com este e-mail já está ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_no_msg_del_err'), 'Nenhuma mensagem foi selecionada para exclusão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_sel_msg_del_msg'), 'As mensagens selecionadas foram excluídas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_pof_upd_msg'), 'O perfil foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_no_ans'), 'Sem resposta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_elementary'), 'Fundamental');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_hi_school'), 'Ensino médio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_some_colg'), 'Alguma Faculdade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_assoc_deg'), 'Grau associado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_bach_deg'), 'Bacharelado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_mast_deg'), 'Mestrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_phd'), 'Ph.D.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_post_doc'), 'Postdoutorado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_single'), 'Solteiro(a)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_married'), 'Casado(a)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_comitted'), 'Comprometido(a)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_open_marriage'), 'Casamento Aberto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_arr_open_relate'), 'Relacionamento Aberto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'title_crt_new_msg'), 'Compor Nova Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'title_forgot'), 'Esqueceu algo? Encontre-o agora!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'title_inbox'), ' - Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'title_sent'), '- Pasta de Envios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'title_usr_contact'), ' Lista de Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'title_usr_fav_vids'), 'Vídeos Favoritos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'title_edit_video'), 'Editar Vídeo - ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_title_err'), 'Digite o título do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_des_err'), 'Digite a descrição do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_tags_err'), 'Por favor, digite Tags para o Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_cat_err'), 'Por favor, escolha pelo menos uma categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_cat_err1'), 'Você só pode escolher até 3 categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_sub_email_msg'), ' e, portanto, esta mensagem é enviada a você automaticamente por que ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_has_upload_nv'), 'Enviou um novo vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_del_selected'), 'Os vídeos selecionados foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_cheat_msg'), 'Por favor, não tente trapacear');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_limits_warn_msg'), 'Por favor, não tente cruzar seus limites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_cmt_del_msg'), 'O comentário foi excluido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_iac_msg'), 'Vídeo está Inativo - Por favor contate o Administrador para mais detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_is_in_process'), 'Vídeo está sendo processado - por favor contate o administrador para mais detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_upload_allow_err'), 'O envio não é permitido pelo proprietário do site');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_download_allow_err'), 'O download de vídeos não é permitido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_edit_owner_err'), 'Você não é proprietário de vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_embed_code_wrong'), 'Código de incorporação esta errado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_seconds_err'), 'Valor errado inserido no campo de segundos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_mins_err'), 'Valor errado inserido no campo de minutos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_thumb_up_err'), 'Erro ao enviar miniatura');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_error_occured'), 'Desculpe, Ocorreu um erro');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_cat_del_msg'), 'A categoria foi excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_del_msg'), 'O vídeo foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_fr_msg'), 'O vídeo foi marcado como «Vídeo em Destaque»');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_fr_msg1'), 'O vídeo foi removido de «Vídeos em destaque»');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_act_msg'), 'O vídeo foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_act_msg1'), 'O vídeo foi desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_update_msg'), 'Detalhes do vídeo atualizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_comment_err'), 'Você deve logar antes de postar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_comment_err1'), 'Por favor, digite algo na Caixa de Comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_comment_err2'), 'Você não pode publicar um comentário no seu próprio vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_comment_err3'), 'Você já postou um comentário, por favor espere pelos outros.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_comment_err4'), 'Você já respondeu a um comentário, por favor espere pelos outros.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_comment_err5'), 'Você não pode postar uma resposta a si mesmo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_comment_msg'), 'O comentário foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_comment_err6'), 'Por favor, inicie a sessão para avaliar o comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_comment_err7'), 'Você já avaliou este comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_fav_err'), 'Este vídeo já foi adicionado aos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_fav_msg'), 'Este vídeo foi adicionado aos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_flag_err'), 'Você já sinalizou este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_flag_msg'), 'Este vídeo foi sinalizado como inapropriado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_flag_rm'), 'Sinalizador(es) Foi/Foram removido(s)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_send_msg_err'), 'Digite um nome de usuário ou selecione qualquer usuário para enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_invalid_user'), 'Nome de usuário inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_subj_err'), 'Assunto da mensagem está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_msg_err'), 'Por favor, digite algo na caixa de mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_sent_you_msg'), 'Enviou uma mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_sent_prvt_msg'), 'Enviou-lhe uma mensagem privada em ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_click_inbox'), 'Clique aqui para visualizar sua caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_click_login'), 'Clique aqui para entrar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_email_notify'), 'Notificação de Email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_msg_has_sent_to'), 'A mensagem foi enviada para ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_inbox_del_msg'), 'A mensagem foi apagada da caixa de entrada ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_sent_del_msg'), 'A mensagem foi excluída da pasta Enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_msg_exist_err'), 'A Mensagem Não Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_del_err'), 'O vídeo não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_unsub_msg'), 'Sua assinatura foi cancelada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_sub_exist_err'), 'A assinatura não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_rm_fav_msg'), 'O vídeo foi removido dos favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_fav_err1'), 'Este vídeo não está na sua lista de favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_cont_del_msg'), 'O contato foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_cot_err'), 'Desculpe, este contato não está na sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_ep_err1'), 'Você já escolheu 10 vídeos, por favor, exclua um para adicionar mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_vdo_exist_err'), 'Desculpe, o vídeo não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_img_gif_err'), 'Por favor envie apenas imagem Gif');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_img_png_err'), 'Por favor envie apenas uma imagem Png');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_img_jpg_err'), 'Por favor, envie apenas imagem Jpg');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'class_logo_msg'), 'O logotipo foi alterado. Por favor, limpe o cache se você não é capaz de ver o logotipo mudado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_forgot_username'), 'Esqueceu seu Usuário | Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_join_now'), 'Cadastre-se agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_my_account'), 'Minha Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_manage_vids'), 'Gerenciar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_view_channel'), 'Ver Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_my_inbox'), 'Minha Caixa de Entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_welcome'), 'Bem-vindo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_top_mem'), 'Membros populares ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_vidz'), 'Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_sign_up_now'), 'Inscreva-se agora!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_my_videos'), 'Meus Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_my_channel'), 'Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_my_subs'), 'Minhas inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_user_no_contacts'), 'O Usuário não tem qualquer Contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_user_no_vides'), 'O usuário não possui nenhum vídeo favorito');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_user_no_vid_com'), 'O usuário não tem comentários de vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_view_all_contacts'), 'Ver todos os contatos de');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_view_fav_all_videos'), 'Ver todos os vídeos favoritos de');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_login_success_msg'), 'Você foi logado com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_logout_success_msg'), 'Você foi desconectado com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_not_redirecting'), 'Agora você está sendo redirecionando.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_not_redirecting_msg'), 'Se você não estiver sendo redirecionando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_manage_contacts'), 'Gerenciar Contatos ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_manage_fav'), 'Gerenciar Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_manage_subs'), 'Gerenciar Inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_subscribe_to'), 'Inscrever-se no canal de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_total_subs'), 'Total de Inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_total_vids'), 'Total de vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_date_subscribed'), 'Data da Inscrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_search_results'), 'Resultados da busca');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_advance_results'), 'Busca avançada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'com_search_results_in'), 'Resultados da Pesquisa em');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'videos_being_watched'), 'Visualizados Recentemente...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'latest_added_videos'), 'Adições Recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'most_viewed'), 'Mais Vistos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'recently_added'), 'Adicionado Recentemente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'featured'), 'Em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'highest_rated'), 'Melhor avaliado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'most_discussed'), 'Mais discutidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'style_change'), 'Alteração de Estilo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'rss_feed_latest_title'), 'RSS feed para vídeos mais recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'rss_feed_featured_title'), 'RSS feed para vídeos em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'rss_feed_most_viewed_title'), 'Feed RSS para vídeos mais populares');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_folder'), 'pt-br');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'reg_closed'), 'Registro fechado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'reg_for'), 'Cadastramento para');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'is_currently_closed'), 'está atualmente fechado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'about_us'), 'Sobre nós');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'account'), 'Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'added'), 'Adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'advertisements'), 'Anúncios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'all'), 'Todos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'active'), 'Ativo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'activate'), 'Ativar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'deactivate'), 'Desativar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'age'), 'Idade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'approve'), 'Aprovar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'approved'), 'Aprovado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'approval'), 'Aprovação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'books'), 'Livros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'browse'), 'Navegar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'by'), 'por');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cancel'), 'Cancelar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'categories'), 'Categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'category'), 'Categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'channels'), 'Canais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'check_all'), 'Marcar todos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'click_here'), 'Clique Aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'comments'), 'Comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'comment'), 'Comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'community'), 'Comunidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'companies'), 'Empresas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'contacts'), 'Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'contact_us'), 'Contate-nos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'country'), 'País');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'created'), 'Criado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'date'), 'Data');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'date_added'), 'Data de Adição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'date_joined'), 'Data de inscrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'dear'), 'Caro(a)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'delete'), 'Excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add'), 'Adicionar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'delete_selected'), 'Excluir Selecionados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'des_title'), 'Descrição:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'duration'), 'Duração');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'education'), 'Educação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'email'), 'E-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'embed'), 'Incorporar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'embed_code'), 'Código de Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'favourite'), 'Favorito');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'favourited'), 'Adicionado aos Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'favourites'), 'Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'female'), 'Mulher');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'filter'), 'Filtro');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'forgot'), 'Esqueci');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'friends'), 'Amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'from'), 'De');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'gender'), 'Sexo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'groups'), 'Grupos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'hello'), 'Olá');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'help'), 'Ajuda');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'hi'), 'Olá');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'hobbies'), 'Passatempos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'Home'), 'Início');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'inbox'), 'Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'interests'), 'Interesses');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'join_now'), 'Junte-se agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'joined'), 'Juntou-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'join'), 'Juntar-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'keywords'), 'Palavras-chave');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'latest'), 'Recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'leave'), 'Sair');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'location'), 'Localização');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'login'), 'Entrar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'logout'), 'Sair');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'male'), 'Homem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'members'), 'Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'messages'), 'Mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'message'), 'Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'minute'), 'minuto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'minutes'), 'minutos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'most_members'), 'Mais Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'most_recent'), 'Mais Recente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'most_videos'), 'Mais vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'music'), 'Música');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'my_account'), 'Minha Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'next'), 'Próxima');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no'), 'Não');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_user_exists'), 'Nenhum Usuário Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_video_exists'), 'Nenhum Vídeo Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'occupations'), 'Ocupações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'optional'), 'opcional');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'owner'), 'Dono');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'password'), 'senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please'), 'Por favor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'privacy'), 'Privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'privacy_policy'), 'Política de Privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'random'), 'Aleatório');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'rate'), 'Avalie');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'request'), 'Solicitar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'related'), 'Relacionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'reply'), 'Responder');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'results'), 'Resultados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'relationship'), 'Relacionamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'second'), 'segundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'seconds'), 'segundos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'select'), 'Selecionar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'send'), 'Enviar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'sent'), 'Enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'signup'), 'Criar conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'subject'), 'Assunto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'tags'), 'Tags');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'times'), 'Tempos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'to'), 'Para');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'type'), 'Tipo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update'), 'Atualizar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload'), 'Enviar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'url'), 'URL');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'verification'), 'Verificação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'videos'), 'Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'viewing'), 'Visualizando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'welcome'), 'Bem-vindo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'website'), 'Página Web');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'yes'), 'Sim');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'of'), 'de');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'on'), 'em');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'previous'), 'Anterior');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'rating'), 'Avaliação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ratings'), 'Avaliações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remote_upload'), 'Envio Remoto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remove'), 'Remover');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'search'), 'Pesquisar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'services'), 'Serviços');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_all'), 'Mostrar tudo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'signupup'), 'Cadastre-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'sort_by'), 'Ordenar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'subscriptions'), 'Inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'subscribers'), 'Inscritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'tag_title'), 'Tags');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'track_title'), 'Faixa de áudio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'time'), 'tempo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'top'), 'Topo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'tos_title'), 'Termos de Uso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'username'), 'Nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'views'), 'Visualizações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'proccession_wait'), 'Processando, Por favor, aguarde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'mostly_viewed'), 'Mais Vistos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'most_comments'), 'Mais comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'group'), 'Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'not_logged_in'), 'Você não está logado ou não tem permissão para acessar esta página. Isto pode ocorrer devido a vários motivos:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'fill_auth_form'), 'Você não está conectado. Preencha o formulário abaixo e tente novamente.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'insufficient_privileges'), 'Você pode não ter privilégios suficientes para acessar esta página.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'admin_disabled_you'), 'O administrador do site pode ter desabilitado sua conta ou pode estar aguardando ativação.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'Recover_Password'), 'Recuperar Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'Submit'), 'Enviar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'Reset_Fields'), 'Limpar campos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'admin_reg_req'), 'O administrador pode ter exigido que você se registre antes de poder ver esta página.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_change'), 'Alterar Idioma');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_changed'), 'Seu idioma foi alterado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_choice'), 'Idioma');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'if_not_redir'), 'Clique aqui para continuar se você não é redirecionado automaticamente.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'style_changed'), 'Seu estilo foi alterado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'style_choice'), 'Estilo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_edit_vdo'), 'Editar Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_stills'), 'Travas de vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_watch_video'), 'Assistir Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_video_details'), 'Detalhes do Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_title'), 'Título');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_desc'), 'Descrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_cat'), 'Categoria do Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_cat_msg'), 'Você pode selecionar até %s categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_tags_msg'), 'As tags são separadas por vírgulas, como nesse exemplo: Teste, Engraçado, Divertido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_br_opt'), 'Opções de Transmissão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_br_opt1'), 'Público - Compartilhe seu vídeo com todos! (recomendado)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_br_opt2'), 'Privado - Visível apenas para você e seus amigos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_date_loc'), 'Data e Localização');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_date_rec'), 'Data de gravação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_for_date'), 'formato MM / DD / YYYY ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_add_eg'), 'Exemplo: Gronelândia de Londres, Sialkot Mubarak Pura');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_share_opt'), 'Opções de compartilhamento e privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_allow_comm'), 'Permitir comentários ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_dallow_comm'), 'Não permitir comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_comm_vote'), 'Votação de Comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_allow_com_vote'), 'Permitir votação nos comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_dallow_com_vote'), 'Não permitir nos comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_allow_rating'), 'permitir avaliação neste vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_embedding'), 'Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_embed_opt1'), 'As pessoas podem reproduzir este vídeo em outros sites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_update_title'), 'Atualizar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_inactive_msg'), 'Sua conta está inativa. Por favor ative-a para fazer upload de vídeos. Para ativar sua conta, por favor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_click_here'), 'Clique Aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_continue_upload'), 'Continuar para o envio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_upload_step1'), 'Envio do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_upload_step2'), 'Etapa do Vídeo %s/2');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_upload_step3'), '(Passo 2/2)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_select_vdo'), 'Selecione um vídeo para enviar.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_enter_remote_url'), 'Digite a URL do vídeo.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_enter_embed_code_msg'), 'Insira o Código de Incorporação do Vídeo de outros sites, ou seja, Youtube ou Metacafe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_enter_embed_code'), 'Inserir Código de Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_enter_druation'), 'Digite a duração');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_select_vdo_thumb'), 'Selecionar miniatura do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_having_trouble'), 'Está com problemas?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_if_having_problem'), 'se você estiver tendo problemas com o carregador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_clic_to_manage_all'), 'Clique Aqui para Gerenciar Todos os Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_manage_vdeos'), 'Gerenciar Vídeos ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_status'), 'Situação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_rawfile'), 'RawFile');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_video_upload_complete'), 'Envio do Vídeo - Envio Completo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_thanks_you_upload_complete_1'), 'Obrigado! Seu envio foi concluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_thanks_you_upload_complete_2'), 'Este vídeo estará disponível em');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_after_it_has_process'), 'após o processamento ter terminado.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_embed_this_video_on_web'), 'Incorpore este vídeo no seu site.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_copy_and_paste_the_code'), 'Copie e cole o código abaixo para incorporar este vídeo.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_upload_another_video'), 'Enviar outro Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_goto_my_videos'), 'Ir para Meus Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_sperate_emails_by'), 'separe e-mails por vírgulas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_personal_msg'), 'Mensagem Pessoal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_related_tags'), 'Tags Relacionadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_reply_to_this'), 'Responder a este ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_add_reply'), 'Adicionar resposta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_share_video'), 'Compartilhar Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_about_this_video'), 'Sobre este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_post_to_a_services'), 'Postar em um Serviço Agregador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_commentary'), 'Comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_post_a_comment'), 'Publicar um comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_add_vdo_msg'), 'Adicionar vídeos ao grupo ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_no_vdo_msg'), 'Você não possui nenhum vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_add_to'), 'Adicionar ao grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_add_vdos'), 'Adicionar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_name_title'), 'Nome do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tag_title'), 'Tags:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_des_title'), 'Descrição:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tags_msg'), 'Insira uma ou mais tags, separadas por espaços.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_tags_msg1'), 'Insira uma ou mais tags, separadas por espaços. Tags são palavras-chave usadas para descrever o seu grupo, para que possa ser facilmente encontrado por outros usuários. Por exemplo, se temos um grupo para surfistas, podemos designá-lo: navegar, praia, ondas.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_url_title'), 'Escolha uma URL única para o nome do grupo:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_url_msg'), 'Insira 3-18 caracteres sem espaços (como «skates de skates»), que se tornarão parte do endereço web do seu grupo. Por favor, note que o nome do grupo escolhido é permanente e não pode ser alterado.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_cat_tile'), 'Categoria do Grupo:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_vdo_uploads'), 'Upload de vídeo:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_forum_posting'), 'Publicação no Fórum:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_join_opt1'), 'Público, qualquer um pode entrar.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_join_opt2'), 'Protegido, requer aprovação do fundador para entrar.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_join_opt3'), 'Privado, apenas por convite do fundador, somente membros podem ver os detalhes do grupo.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_vdo_opt1'), 'Postar vídeos imediatamente.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_vdo_opt2'), 'Aprovação de fundador necessária antes do vídeo estar disponível.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_vdo_opt3'), 'Somente o Fundador pode adicionar novos vídeos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_post_opt1'), 'Publicar tópicos imediatamente.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_post_opt2'), 'É necessária a aprovação de fundador antes que o tópico esteja disponível.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_post_opt3'), 'Somente o fundador pode criar um novo tópico.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_crt_grp'), 'Criar grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_thumb_title'), 'Miniatura do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_upl_thumb'), 'Enviar Miniatura do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_must_be'), 'Deve ser');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_90x90'), '90  x 90 de tamanho dará a melhor qualidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_thumb_warn'), 'Não Envie Material Vulgar/Pornografico ou Com Direitos Autorais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_del_confirm'), 'Você tem certeza que deseja excluir este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_del_success'), 'Você excluiu com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_click_go_grps'), 'Clique Aqui Para Ir Para Os Grupos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_edit_grp_title'), 'Editar Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_manage_vdos'), 'Gerenciar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_manage_mems'), 'Gerenciar Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_del_group_title'), 'Excluir grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_add_vdos_title'), 'Adicionar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_join_grp_title'), 'Juntar-se ao grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_leave_group_title'), 'Deixar o Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_invite_grp_title'), 'Convidar Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_view_mems'), 'Ver Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_view_vdos'), 'Ver vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_create_grp_title'), 'Criar um novo grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_most_members'), 'Mais Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_most_discussed'), 'Mais discutidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_invite_msg'), 'Convidar usuários para este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_invite_msg1'), 'Convidou você para se juntar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_invite_msg2'), 'Digite os E-mails ou nomes de usuário (separados por vírgulas)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_url_title1'), 'URL do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_invite_msg3'), 'Enviar convite');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_join_confirm_msg'), 'Você tem certeza que quer se juntar a este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_join_msg_succ'), 'Você entrou no grupo com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_click_here_to_go'), 'Clique Aqui para ir para');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_leave_confirm'), 'Você tem certeza que quer sair deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_leave_succ_msg'), 'Você saiu do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_manage_members_title'), 'Gerenciar Membros ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_for_approval'), 'Para aprovação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_rm_videos'), 'Remover Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_rm_mems'), 'Remover Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_groups_title'), 'Gerenciar Grupos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_joined_title'), 'Gerenciar Grupos Cadastrados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_remove_group'), 'Remover Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_bo_grp_found'), 'Nenhum grupo encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_joined_groups'), 'Grupos que Juntou-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_owned_groups'), 'Grupos que é Dono');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_edit_this_grp'), 'Editar este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_topics_title'), 'Tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_topic_title'), 'Tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_posts_title'), 'Postagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_discus_title'), 'Discussões');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_author_title'), 'Autor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_replies_title'), 'Respostas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_last_post_title'), 'Última postagem ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_viewl_all_videos'), 'Ver todos os vídeos deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_add_new_topic'), 'Adicionar Novo Tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_attach_video'), 'Anexar vídeo ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_add_topic'), 'Adicionar Tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_please_login'), 'Por favor, entre para postar tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_please_join'), 'Por favor, junte-se a este grupo para postar tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_inactive_account'), 'Sua Conta Está Inativa e Requer Ativação do Proprietário do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_about_this_grp'), 'Sobre este grupo ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_no_vdo_err'), 'Este Grupo Não Tem Videos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_posted_by'), 'Publicado por');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_add_new_comment'), 'Adicionar Novo Comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_add_comment'), 'Adicionar Comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_pls_login_comment'), 'Por favor conecte-se para postar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_pls_join_comment'), 'Por favor, junte-se a este grupo para enviar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_activation_title'), 'Ativação do usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_actiavation_msg'), 'Digite seu nome de usuário e código de ativação que foram enviados para seu e-mail.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_actiavation_msg1'), 'Solicitar Código de Ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_activation_code_tl'), 'Código de Ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_compose_msg'), 'Compor Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_inbox_title'), 'Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_sent_title'), 'Enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_to_title'), 'Para: (Digite o nome do usuário)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_or_select_frm_list'), 'ou selecione da lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_attach_video'), 'Anexar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_attached_video'), 'Vídeo anexado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_no_message'), 'Sem Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_delete_message_msg'), 'Excluir esta mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_forgot_message'), 'Esqueci a senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_forgot_message_2'), 'Não se preocupe, recupere-o agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_pass_reset_msg'), 'Redefinir senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_pass_forgot_msg'), 'se você esqueceu sua senha, digite seu nome de usuário e código de verificação na caixa, e instruções para redefinir a senha serão enviadas para sua caixa de correio.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_veri_code'), 'Código de Verificação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_reocover_user'), 'Recuperar Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_user_forgot_msg'), 'Esqueceu o seu nome de usuário?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_recover'), 'Recuperar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_reset'), 'Redefinir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_inactive_msg'), 'Sua conta está inativa, por favor ative sua conta indo para a <a href=\"./activation.php\">página de ativação</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_dashboard'), 'Painel');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_prof_chnnl'), 'Gerenciar Perfil &amp; Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_friends'), 'Gerenciar Amigos &amp; Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_prof_channel'), 'Perfil/Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_message_box'), 'Caixa de Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_new_messages'), 'Novas mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_goto_inbox'), 'Ir para Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_goto_sentbox'), 'Ir para Caixa de Envios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_compose_new'), 'Compor novas mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_total_subs_users'), 'Total de usuários inscritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_you_have'), 'Você possui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_fav_videos'), 'Vídeos Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_your_vids_watched'), 'Seus vídeos assistidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_times'), 'Tempos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_you_have_watched'), 'Você assistiu');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_channel_profiles'), 'Canal e Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_channel_views'), 'Visualizações do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_channel_comm'), 'Comentários do Canal ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_prof'), 'Gerenciar Perfil / Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_you_created'), 'Você criou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_you_joined'), 'Você se juntou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_create_group'), 'Criar Novo Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_my_account'), 'Gerenciar minha conta ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_my_videos'), 'Gerenciar Meus Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_my_channel'), 'Gerenciar Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_sent_box'), 'Meus itens enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_channel'), 'Gerenciar Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_my_contacts'), 'Gerenciar Meus Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_contacts'), 'Gerenciar Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_manage_favourites'), 'Gerenciar Vídeos Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_mem_login'), 'Acesso de membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_already_have'), 'Por favor, entre aqui se você já tem uma conta de');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_forgot_username'), 'Esqueceu o seu nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_forgot_password'), 'Esqueci minha senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_create_your'), 'Crie o seu ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'all_fields_req'), 'Todos os campos são obrigatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_valid_email_addr'), 'Endereço de e-mail válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_allowed_format'), 'Letras A-Z ou a-z, Números 0-9 e Sub-sublinhados _');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_confirm_pass'), 'Confirmar Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_reg_msg_0'), 'Registrar como ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_reg_msg_1'), 'membro, sua versão gratuita e fácil apenas preencha o formulário abaixo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_date_of_birth'), 'Data de nascimento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_enter_text_as_img'), 'Digite o texto como visto na imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_refresh_img'), 'Atualizar imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_i_agree_to_the'), 'Concordo com os  <a href=\"%s\" target=\"_blank\">Termos de Serviço</a> e com a <a href=\"%s\" target=\"_blank\" >Política de Privacidade</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_thanks_for_reg'), 'Obrigado por registrar-se no ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_email_has_sent'), 'Um e-mail foi enviado para sua caixa de entrada contendo sua conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_and_activation'), '&amp; Ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_details_you_now'), 'Detalhes. Agora você pode fazer as seguintes coisas em nossa rede');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_upload_share_vds'), 'Enviar, Compartilhar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_make_friends'), 'Fazer Amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_send_messages'), 'Enviar mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_grow_your_network'), 'Aumente suas redes convidando mais amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_rate_comment'), 'Avaliar e comentar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_make_customize'), 'Faça e Personalize seu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_to_upload_vid'), 'Para Fazer Upload de Vídeo, É necessário ativar a sua conta primeiro, Os detalhes de ativação foram enviados para sua conta de e-mail, pode levar algumas vezes para chegar à sua caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_click_to_login'), 'Clique aqui para acessar sua conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_view_my_channel'), 'Ver Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_change_pass'), 'Alterar senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_email_settings'), 'Configurações de email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_profile_settings'), 'Opções do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_usr_prof_chnl_edit'), 'Editar Perfil de Usuário &amp; Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_personal_info'), 'Informações Pessoais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_fname'), 'Nome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_lname'), 'Sobrenome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_gender'), 'Sexo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_relat_status'), 'Estado de relacionamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_display_age'), 'Mostrar idade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_about_me'), 'Sobre mim');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_website_url'), 'URL do website');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_eg_website'), 'e.g www.seusite.com');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_prof_info'), 'Informações Profissionais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_education'), 'Educação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_school_colleges'), 'Escolas / Faculdades');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_occupations'), 'Ocupação(ões)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_companies'), 'Empresas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_sperate_by_commas'), 'separados por vírgulas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_interests_hobbies'), 'Interesses e Hobbies');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_fav_movs_shows'), 'Filmes favoritos &amp; Séries');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_fav_music'), 'Músicas Favoritas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_fav_books'), 'Livros Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_user_avatar'), 'Avatar de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_upload_avatar'), 'Enviar avatar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_channel_info'), 'Informações do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_channel_title'), 'Título do Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_channel_description'), 'Descrição do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_channel_permission'), 'Permissões do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_allow_comments_msg'), 'Usuários podem comentar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_dallow_comments_msg'), 'Usuários não podem comentar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_allow_rating'), 'Permitir avaliação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_dallow_rating'), 'Não permitir avaliação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_allow_rating_msg1'), 'Usuários podem avaliar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_dallow_rating_msg1'), 'Usuários não podem avaliar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_channel_feature_vid'), 'Vídeo em destaque do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_select_vid_for_fr'), 'Selecione o Vídeo para Definir como Destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_chane_channel_bg'), 'Alterar fundo do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_remove_bg'), 'Remover fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_currently_you_d_have_pic'), 'Atualmente você não possui uma Imagem de Fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_change_email'), 'Alterar Email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_email_address'), 'Endereço de e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_new_email'), 'Novo e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_notify_me'), 'Notificar-me quando o usuário me enviar uma mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_old_pass'), 'Senha Antiga');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_new_pass'), 'Nova senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_c_new_pass'), 'Confirmar Nova Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_doesnt_exist'), 'O usuário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_do_not_have_contact'), 'O usuário não possui nenhum contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_no_fav_video_exist'), 'Usuário não tem nenhum vídeo favorito selecionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_have_no_vide'), 'O usuário não possui vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_s_channel'), 'Canal de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_last_login'), 'Última Conexão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_add_contact'), 'Adicionar contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_dob'), 'DoB');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_movies_shows'), 'Filmes &amp; Séries');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_add_comment'), 'Adicionar Comentário ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_no_fr_video'), 'O usuário não selecionou nenhum vídeo para definir como destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_view_all_video_of'), 'Ver Todos os Vídeos de ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'menu_home'), 'Início');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'menu_inbox'), 'Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_cat_err2'), 'Você não pode selecionar mais de %d categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_subscribe_message'), 'Olá %subscriber%\nVocê se inscreveu no %user% e portanto esta mensagem é enviada para você automaticamente, porque %user% enviou um novo vídeo\n\n%website_title%');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_subscribe_subject'), '%user% enviou um novo vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_already_logged'), 'Você já está logado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_not_logged_in'), 'Você não está logado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'invalid_user'), 'Usuário Inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_cat_err3'), 'Por favor, selecione pelo menos uma categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'embed_code_invalid_err'), 'Código de incorporação de vídeo inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'invalid_duration'), 'Duração inválida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vid_thumb_changed'), 'Miniatura padrão do vídeo foi alterada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vid_thumb_change_err'), 'Miniatura de vídeo não encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_vid_thumbs_msg'), 'Todas as miniaturas de vídeo foram carregadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_thumb_delete_msg'), 'A miniatura do vídeo foi excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_thumb_delete_err'), 'Não foi possível excluir a miniatura do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_comment_del_perm'), 'Você não tem permissão para excluir este comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'my_text_context'), 'Meu contexto de teste');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_contains_disallow_err'), 'Nome de usuário contém caracteres não permitidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_cat_erro'), 'A categoria já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_cat_no_name_err'), 'Por favor, digite um nome para a categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cat_default_err'), 'O padrão não pode ser excluído, por favor, escolha outra categoria como «padrão» e apague esta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pic_upload_vali_err'), 'Por favor, carregue uma imagem válida de JPG, GIF ou PNG');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cat_dir_make_err'), 'Não foi possível criar o diretório de miniaturas da categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cat_set_default_ok'), 'A categoria foi definida como padrão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vid_thumb_removed_msg'), 'Miniaturas de vídeo removidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vid_files_removed_msg'), 'Os arquivos de vídeo foram removidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vid_log_delete_msg'), 'O registro de vídeo foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_multi_del_erro'), 'Os vídeos foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_fav_message'), 'Este %s foi adicionado aos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'obj_not_exists'), '%s não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'already_fav_message'), 'Este %s já foi adicionado aos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'obj_report_msg'), 'Este %s foi reportado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'obj_report_err'), 'Você já denunciou este %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_no_exist_wid_username'), '\'%s\' não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'share_video_no_user_err'), 'Por favor insira nomes de usuário ou e-mails para enviar este %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'today'), 'Hoje');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'yesterday'), 'Ontem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'thisweek'), 'Esta Semana');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lastweek'), 'Última Semana');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'thismonth'), 'Este Mês');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lastmonth'), 'Último Mês');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'thisyear'), 'Este Ano');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lastyear'), 'Último Ano');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'favorites'), 'Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'alltime'), 'Desde o Inicio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'insufficient_privileges_loggin'), 'Você não pode acessar esta página, faça o login ou registre-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'profile_title'), 'Título de Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_dob'), 'Mostrar Data de Nascimento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'profile_tags'), 'Tags do Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'profile_desc'), 'Descrição do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'online_status'), 'Situação do Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_profile'), 'Mostrar Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'allow_ratings'), 'Permitir avaliações de perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'postal_code'), 'Código postal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'temp_file_load_err'), 'Não foi possível carregar o arquivo de tempalte \'%s\' no diretório \'%s\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_date_provided'), 'Nenhuma data fornecida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'bad_date'), 'Nunca');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'users_videos'), 'Vídeos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_login_subscribe'), 'Por favor, faça o login para inscrever-se em %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'users_subscribers'), 'Inscritos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_no_subscribers'), '%s não tem inscritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_subscriptions'), 'Inscrições de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_no_subscriptions'), '%s não possui inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'usr_avatar_bg_update'), 'O avatar do usuário e o plano de fundo foram atualizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_email_confirm_email_err'), 'Confirmar e-mail incorreto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'email_change_msg'), 'E-mail foi alterado com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_edit_video'), 'Você não pode editar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'confirm_del_video'), 'Tem certeza de que deseja excluir este vídeo?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remove_fav_video_confirm'), 'Tem certeza de que deseja remover este vídeo dos seus favoritos?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remove_fav_collection_confirm'), 'Tem certeza de que deseja remover esta coleção dos seus favoritos?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'fav_remove_msg'), '%s foi removido dos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'unknown_favorite'), 'Favoritos desconhecidos %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_multi_del_fav_msg'), 'Os vídeos foram removidos dos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'unknown_sender'), 'Remetente desconhecido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_message'), 'Por favor, digite algo para a mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'unknown_reciever'), 'Destinatário desconhecido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_pm_exist'), 'A mensagem privada não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pm_sent_success'), 'Mensagem privada enviada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'msg_delete_inbox'), 'A mensagem foi excluída da caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'msg_delete_outbox'), 'A mensagem foi excluída da sua caixa de saída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'private_messags_deleted'), 'As mensagens privadas foram excluídas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ban_users'), 'Banir Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'spe_users_by_comma'), 'separar nomes de usuários por vírgula');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_ban_msg'), 'Lista de bloqueio de usuários atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_user_ban_msg'), 'Nenhum usuário foi banido da sua conta!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'thnx_sharing_msg'), 'Obrigado por compartilhar %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_own_commen_rate'), 'Você não pode avaliar seu próprio comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_comment_exists'), 'O comentário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'thanks_rating_comment'), 'Obrigado por avaliar o comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_login_create_playlist'), 'Por favor, faça login para criar listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_have_no_playlists'), 'O usuário não possui listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'play_list_with_this_name_arlready_exists'), 'Já existe uma lista de reprodução com o nome \'%s\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_playlist_name'), 'Digite o nome da lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'new_playlist_created'), 'Nova playlist criada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_not_exist'), 'A lista de reprodução não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_item_not_exist'), 'O item na lista de reprodução não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_item_delete'), 'O item da lista de reprodução foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'play_list_updated'), 'Lista de reprodução atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_hv_permission_del_playlist'), 'Você não tem permissão para excluir a lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_delete_msg'), 'Lista de reprodução excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_name'), 'Nome da Lista de Reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_new_playlist'), 'Adicionar Lista de Reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'this_thing_added_playlist'), 'Este %s foi adicionado à lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'this_already_exist_in_pl'), 'Este %s já existe na sua lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'edit_playlist'), 'Editar lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remove_playlist_item_confirm'), 'Tem certeza de que deseja remover isto da sua lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remove_playlist_confirm'), 'Tem certeza que deseja excluir esta lista de reprodução?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'avcode_incorrect'), 'Código de ativação incorreto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'group_join_login_err'), 'Por favor, faça o login para participar deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_playlist'), 'Gerenciar listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'my_notifications'), 'Minhas notificações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'users_contacts'), 'Contatos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'type_flags_removed'), '%s sinalizações foram removidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'terms_of_serivce'), 'Termos de Serviço');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'users'), 'Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'login_to_mark_as_spam'), 'Por favor, faça login para marcar como spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_own_commen_spam'), 'Você não pode marcar seu próprio comentário como spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'already_spammed_comment'), 'Você já marcou este comentário como spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'spam_comment_ok'), 'O comentário foi marcado como spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'arslan_hassan'), 'Arslan Hassan');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_not_allowed_add_grp_vids'), 'Você não é membro deste grupo, então não pode adicionar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'sel_vids_updated'), 'Os vídeos selecionados foram atualizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'unable_find_download_file'), 'Não foi possível encontrar o arquivo de download');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_edit_group'), 'Você não pode editar esse grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_invite_mems'), 'Você não pode convidar membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_moderate_group'), 'Você não pode moderar este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_doesnt_exist'), 'A página não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pelase_select_img_file_for_vdo'), 'Por favor, selecione o arquivo de imagem para miniatura do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'new_mem_added'), 'Um novo membro foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'this_vdo_not_working'), 'Este vídeo pode não funcionar corretamente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'email_template_not_exist'), 'Modelo de email não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'email_subj_empty'), 'Assunto do email está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'email_msg_empty'), 'A mensagem de e-mail está vazia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'email_tpl_has_updated'), 'Modelo de E-mail foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_name_empty'), 'O nome da página está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_title_empty'), 'O título da página está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_content_empty'), 'O conteúdo da página estava vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'new_page_added_successfully'), 'Nova página foi adicionada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_updated'), 'A página foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_deleted'), 'Página excluída com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_activated'), 'A página foi ativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_deactivated'), 'A página foi desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_delete_this_page'), 'Você não pode excluir esta página');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'ad_placement_err4'), 'O posicionamento não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_details_updated'), 'Os detalhes do grupo foram atualizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_del_topic'), 'Você não pode apagar este tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_del_user_topics'), 'Você não pode excluir tópicos de usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'topics_deleted'), 'Os tópicos foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_delete_grp_topics'), 'Você não pode excluir tópicos do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_not_allowed_post_topics'), 'Você não tem permissão para postar tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_add_this_vdo'), 'Você não pode adicionar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_added'), 'O vídeo foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_del_this_vdo'), 'Você não pode remover este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_removed'), 'O vídeo foi removido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_not_grp_mem'), 'O usuário não é membro do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_already_group_mem'), 'O usuário já ingressou neste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'invitations_sent'), 'Os convites foram enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_not_grp_mem'), 'Você não é membro deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_delete_this_grp'), 'Você não pode excluir este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_deleted'), 'O grupo foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_del_grp_mems'), 'Você não pode excluir membros do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'mems_deleted'), 'Os membros foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_del_grp_vdos'), 'Você não pode excluir vídeos de grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'thnx_for_voting'), 'Obrigado por votar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_hv_already_rated_vdo'), 'Você já avaliou este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_login_to_rate'), 'Por favor, inicie a sessão para avaliar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_not_subscribed'), 'Você não está inscrito');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_delete_this_user'), 'Você não pode excluir este usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_hv_perms'), 'Você não tem permissões suficientes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_subs_hv_been_removed'), 'As inscrições do usuário foram removidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_subsers_hv_removed'), 'Os inscritos do usuário foram removidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_already_sent_frend_request'), 'Você já enviou um pedido de amizade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'friend_added'), 'O amigo foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'friend_request_sent'), 'Pedido de amizade enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'friend_confirm_error'), 'Ou o usuário não solicitou seu pedido de amizade ou você já o confirmou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'friend_confirmed'), 'O amigo foi confirmado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'friend_request_not_found'), 'Nenhum pedido de amizade encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_confirm_this_request'), 'Você não pode confirmar este pedido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'friend_request_already_confirmed'), 'Pedido de amizade já confirmado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_no_in_contact_list'), 'O usuário não está na sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_removed_from_contact_list'), 'O usuário foi removido da sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cant_find_level'), 'Nível não encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_level_name'), 'Digite o nome do nível');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'level_updated'), 'O nível foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'level_del_sucess'), 'O nível de usuário foi excluído, todos os usuários deste nível foram transferidos para %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'level_not_deleteable'), 'Este nível não é deletável');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pass_mismatched'), 'Senhas não coincidem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_blocked'), 'O usuário foi bloqueado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_already_blocked'), 'O usuário já está bloqueado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_del_user'), 'Você não pode bloquear este usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_vids_hv_deleted'), 'Os vídeos do usuário foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_contacts_hv_removed'), 'Os contatos do usuário foram removidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'all_user_inbox_deleted'), 'Todas as mensagens da Caixa de Entrada do Usuário foram excluidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'all_user_sent_messages_deleted'), 'Todas as mensagens enviadas pelo usuário foram excluídas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pelase_enter_something_for_comment'), 'Por favor, digite algo na caixa de comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_your_name'), 'O nome não pode ser deixado em branco');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_your_email'), 'Por favor, insira o seu e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'template_activated'), 'O modelo foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'error_occured_changing_template'), 'Ocorreu um erro ao alterar o modelo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'phrase_code_empty'), 'O código da frase estava vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'phrase_text_empty'), 'O texto da frase estava vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'language_does_not_exist'), 'O idioma não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'name_has_been_added'), '%s foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'name_already_exists'), '\'%s\' já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_doesnt_exist'), 'O idioma não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_file_was_selected'), 'Nenhum arquivo foi selecionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'err_reading_file_content'), 'Erro ao ler conteúdo do arquivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cant_find_lang_name'), 'Nome do idioma não encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cant_find_lang_code'), 'Não conseguimos encontrar o código do idioma');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_phrases_found'), 'Nenhuma frase foi encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'language_already_exists'), 'O idioma já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_added'), 'Idioma adicionado com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'error_while_upload_file'), 'Ocorreu um erro ao carregar o arquivo do idioma');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'default_lang_del_error'), 'Este é o idioma padrão, selecione outro idioma como «padrão» e então exclua este pacote');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_deleted'), 'O pacote de idioma foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_name_empty'), 'O nome do idioma está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_code_empty'), 'O código do idioma estava vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_regex_empty'), 'Expressão regular do idioma estava vazia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_code_already_exist'), 'O código de idioma já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_updated'), 'O idioma foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'player_activated'), 'O player foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'error_occured_while_activating_player'), 'Ocorreu um erro ao ativar o player');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_has_been_s'), 'O plug-in foi %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_uninstalled'), 'O plug-in foi desinstalado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'perm_code_empty'), 'O código de permissão está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'perm_name_empty'), 'O nome da permissão está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'perm_already_exist'), 'A permissão já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'perm_type_not_valid'), 'Tipo de permissão inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'perm_added'), 'Nova permissão foi adicionada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'perm_deleted'), 'A permissão foi excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'perm_doesnt_exist'), 'A permissão não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'acitvation_html_message'), 'Digite seu nome de usuário e código de ativação para ativar sua conta. Não esqueça de checar a sua caixa de entrada para encontrar o código de ativação, caso não tenha recebido um, por favor solicite-o preenchendo o formulário a seguir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'acitvation_html_message2'), 'Por favor, digite seu endereço de e-mail para solicitar o código de ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'admin_panel'), 'Painel de Administração');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'moderate_videos'), 'Moderar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'moderate_users'), 'Moderar Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'revert_back_to_admin'), 'Reverter para o administrador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'more_options'), 'Mais Opções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'downloading_string'), 'Baixando %s...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'download_redirect_msg'), '<a href=\"%s\">clique aqui se você não for redirecionado automaticamente</a> - <a href=\"%s\"> Clique Aqui para voltar à Página do Vídeo</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'account_details'), 'Detalhes de conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'profile_details'), 'Detalhes do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update_profile'), 'Atualizar o perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_select_img_file'), 'Por favor, selecione arquivo de imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'or'), 'ou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pelase_enter_image_url'), 'Digite a URL da imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_bg'), 'Fundo do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_bg_img'), 'Imagem de Fundo do Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_bg_color'), 'Digite a cor de fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'bg_repeat_type'), 'Tipo de repetição de fundo (se estiver usando a imagem como plano de fundo)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'fix_bg'), 'Corrigir fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'delete_this_img'), 'Excluir esta imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'current_email'), 'E-mail atual');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'confirm_new_email'), 'Confirme o novo email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_subs_found'), 'Nenhum inscrição encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_info_all_fields_req'), 'Informações de Vídeo - Todos os campos são obrigatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update_group'), 'Atualizar Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'default'), 'Padrão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_info_all_fields_req'), 'Informações do Grupo - Todos os Campos são Obrigatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'date_recorded_location'), 'Data de gravação &amp; localização');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update_video'), 'Atualizar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'click_here_to_recover_user'), 'Clique aqui para recuperar o nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'click_here_reset_pass'), 'Clique aqui para redefinir a senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remember_me'), 'Lembrar de mim');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'howdy_user'), 'Olá %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'notifications'), 'Notificações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlists'), 'Listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'friend_requests'), 'Pedidos de Amizade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'after_meny_guest_msg'), 'Bem-vindo, convidado! Por favor <a href=\"%s\">faça o login</a> ou <a href=\"%s\">registre-se</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'being_watched'), 'Sendo assistido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'change_style_of_listing'), 'Alterar estilo da listagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'website_members'), '%s Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'guest_homeright_msg'), 'Assistir, enviar, compartilhar e muito mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'reg_for_free'), 'Registre-se gratuitamente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'rand_vids'), 'Vídeos Aleatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 't_10_users'), 'Top 10 Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pending'), 'Pendente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'confirm'), 'Confirmar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_contacts'), 'Sem contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_hv_any_grp'), 'Você não tem nenhum grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_joined_any_grp'), 'Você não entrou em nenhum grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'leave_groups'), 'Sair de grupos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_grp_mems'), 'Gerenciar membros do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pending_mems'), 'Membros pendentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'active_mems'), 'Membros ativos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'disapprove'), 'Reprovar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_grp_vids'), 'Gerenciar vídeos em grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pending_vids'), 'Vídeos pendentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_pending_vids'), 'Nenhum vídeo pendente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_active_videos'), 'Não há vídeos ativos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'active_videos'), 'Vídeos ativos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_playlists'), 'Gerenciar listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_items'), 'Total de itens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'play_now'), 'REPRODUZA AGORA');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_video_in_playlist'), 'Esta playlist não tem nenhum vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view'), 'Ver');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_hv_fav_vids'), 'Você não tem nenhum vídeo favorito');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'private_messages'), 'Mensagens Privadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'new_private_msg'), 'Nova mensagem particular');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'search_for_s'), 'Pesquisar por %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'signup_success_usr_ok'), '<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">Apenas mais um passo</h2>     \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 14px;\">Você é apenas um passo para trás de se tornar um meme oficial do nosso site. Por favor, verifique seu e-mail, enviamos um e-mail de confirmação que contém um link de confirmação do nosso site. Por favor, clique nele para completar o seu registro.</p>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'signup_success_usr_emailverify'), '<h2 style=\"font-family:Arial,Verdana,sans-serif; margin:5px 5px 8px;\">Bem-vindo à nossa comunidade</h2>\n    \t<p style=\"margin:0px 5px; line-height:18px; font-size:11px;\">Seu e-mail foi confirmado, Por favor <strong><a href=\"%s\">clique aqui para fazer login</a></strong> e continuar como nosso membro registrado.</p>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'if_you_already_hv_account'), 'se você já tem uma conta, faça login aqui ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'signup_message_under_login'), ' <p>Nosso site é o lar do vídeo online:</p>\n          \n            <ul><li><strong>Assista</strong> milhares de vídeos</li><li><strong>Compartilhe seus favoritos</strong> com amigos e familiares</li>\n            <li><strong>Conecte-se com outros usuários</strong> que compartilham seus interesses</li><li><strong>Envie seus vídeos</strong> para uma audiência mundial\n\n</li></ul>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'new_mems_signup_here'), 'Novos membros se registram aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'register_as_our_website_member'), 'Registre-se como membro, é gratuito e fácil apenas ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_complete_msg'), '<h2>O Upload de vídeo foi concluído</h2>\n<span class=\"header1\">Obrigado! Seu upload está completo.</span><br>\n<span class=\"tips\">Este vídeo estará disponível em <a href=\"%s\"><strong>Meus Vídeos</strong></a> depois de ter terminado de processar.</span>  \n<div class=\"upload_link_button\" align=\"center\">\n    </h2>    <ul>\n        <li><a href=\"%s\" >Enviar Outro Vídeo</a></li>\n        <li><a href=\"%s\" >Vá para Meus Vídeos</a></li>\n    </ul>\n<div class=\'clearfix\'></div>\n</div>\n');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_right_guide'), ' <div>\n            <div>\n              <p>\n                <strong>\n                <strong>Importante:</strong>\n                Não envie nenhum programa de TV, vídeos de musicas, shows de música, ou comerciais sem permissão, a menos que consistam inteiramente de conteúdo que você mesmo criou.</strong></p>\n                <p>As paginas de \n                <a href=\"#\">Direitos Autorais</a> e as \n                <a href=\"#\">Diretrizes da Comunidade</a> podem ajudá-lo a determinar se seu vídeo viola os direitos autorais de outra pessoa.</p>\n                <p>clicando em \"Enviar Vídeo\", você está representando que este vídeo não viola os \n                <a id=\"terms-of-use-link\" href=\"#\">Termos de Uso</a> \n                do nosso site e que você possui todos os direitos autorais sobre este vídeo ou tem autorização para envia-lo.</p>\n            </div>\n        </div>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'report_this_user'), 'Denunciar este Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_to_favs'), 'Meu Favorito!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'report_this'), 'Denunciar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'share_this'), 'Compatilhe isto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_to_playlist'), 'Adicionar à lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_profile'), 'Ver Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'subscribe'), 'Inscrever-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'uploaded_by_s'), 'Enviado por %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'more'), 'Mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'link_this_video'), 'Link para o vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'click_to_download_video'), 'Clique aqui para baixar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'name'), 'Nome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'email_wont_display'), 'E-mail (não será exibido)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_login_to_comment'), 'Por favor, inicie a sessão para comentar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'marked_as_spam_comment_by_user'), 'Marcado como spam, comentado por <em>%s</em>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'spam'), 'Spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_commented_time'), '<a href=\"%s\">%s</a> comentou %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_comments'), 'Ninguém comentou sobre este %s ainda');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_video'), 'Assistir ao vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'topic_icon'), 'Ícone do tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'group_options'), 'Opção de grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'info'), 'Informação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'basic_info'), 'Informações básicas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'group_owner'), 'Dono do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_mems'), 'Total de membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_topics'), 'Total de tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grp_url'), 'URL do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'more_details'), 'Mais detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_all_mems'), 'Ver todos os membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_all_vids'), 'Ver Todos os Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'topic_title'), 'Título do Tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'last_reply'), 'Última resposta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'topic_by_user'), '<a href=\"%s\">%s</a></span> por <a href=\"%s\">%s</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_topics'), 'Não há tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'last_post_time_by_user'), '%s<br />\npor <a href=\"%s\">%s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'profile_views'), 'Visualizações do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'last_logged_in'), 'Último acesso em');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'last_active'), 'Última vez ativo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_logins'), 'Total de logins');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_videos_watched'), 'Total de vídeos assistidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_group'), 'Ver grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_hv_any_pm'), 'Não há mensagens para exibir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'date_sent'), 'Data de envio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_hide'), 'Mostrar - Ocultar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'quicklists'), 'Listas rápidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'are_you_sure_rm_grp'), 'Tem certeza que deseja remover este grupo?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'are_you_sure_del_grp'), 'Tem certeza que deseja excluir este grupo?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'change_avatar'), 'Alterar Avatar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'change_bg'), 'Alterar Fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'uploaded_videos'), 'Vídeos enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_playlists'), 'Listas de reprodução de vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_contact_list'), 'Adicionar lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'topic_post'), 'Postagem do tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'invite'), 'Convidar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'time_ago'), '%s %s atrás');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'from_now'), '%s %s a partir de agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_has_been_activated'), 'O idioma foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_has_been_deactivated'), 'O idioma foi desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'lang_default_no_actions'), 'Idioma é padrão então você não pode executar ações nele');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'private_video_error'), 'Este vídeo é privado, somente amigos que enviam podem ver este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'email_send_confirm'), 'Um e-mail foi enviado para o nosso administrador da Web, responderemos em breve');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'name_was_empty'), 'Nome está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'invalid_email'), 'E-mail inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pelase_enter_reason'), 'Motivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_something_for_message'), 'Por favor, digite algo na caixa de mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'comm_disabled_for_vid'), 'Comentários desativados para este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'coments_disabled_profile'), 'Comentários desativados para este perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'file_size_exceeds'), 'Tamanho do arquivo excede \'%s kbs\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vid_rate_disabled'), 'A avaliação do vídeo está desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'chane_lang'), '- Alterar Idioma -');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'recent'), 'Recente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'viewed'), 'Visualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'top_rated'), 'Melhor avaliado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'commented'), 'Comentado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'searching_keyword_in_obj'), 'Pesquisando \'%s\' em %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_results_found'), 'Nenhum resultado encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_val_bw_min_max'), 'Por favor, digite um valor para \'%s\' entre \'%s\' e \'%s\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_new_subs_video'), 'Não foram encontrados novos vídeos nas assinaturas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'inapp_content'), 'Conteúdo inadequado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'copyright_infring'), 'Violação de Direitos Autorais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'sexual_content'), 'Conteúdo Sexual');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'violence_replusive_content'), 'Violência ou conteúdo repugnante');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'disturbing'), 'Perturbador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'other'), 'Outros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pending_requests'), 'Solicitações pendentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'friend_add_himself_error'), 'Você não pode se adicionar como amigo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'contact_us_msg'), 'Os seus comentários são importantes para nós e vamos avaliar eles o mais rapidamente possível. A informação solicitada neste formulário é voluntária. As informações estão a ser recolhidas para fornecer informações adicionais solicitadas por si e ajuda-nos a melhorar os nossos serviços.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'failed'), 'Falha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'required_fields'), 'Campos obrigatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'more_fields'), 'Mais campos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remote_upload_file'), 'enviando arquivo <span id=\\\"remoteFileName\\\"></span>, aguarde...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_remote_file_url'), 'Digite a URL do arquivo remoto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remoteDownloadStatusDiv'), '<div class=\"remoteDownloadStatus\" id=\"remoteDownloadStatus\" >Baixado \n                <span id=\"status\">-- de --</span> @ \n                <span id=\"dspeed\">-- Kpbs</span>, Estimativa \n                <span id=\"eta\">--:--</span>, Tempo Gasto \n                <span id=\"time_took\">--:--</span>\n            </div>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_data_now'), 'Enviar Dados Agora!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'save_data'), 'Dados Salvos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'saving'), 'Salvando...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_file'), 'Enviar arquivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'grab_from_youtube'), 'Resgatar do youtube');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_video_button'), 'Explorar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_videos_can_be'), '<span style=\\\"font-weight: bold; font-size: 13px;\\\">Os vídeos podem ser</span>     <ul>         <li>de Alta Definição</li>         <li>Até %s de tamanho</li>         <li>Até %s de duração</li>         <li>Uma grande variedade de formatos</li>     </ul>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_not_exist'), 'A foto não existe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_success_deleted'), 'A foto foi excluída com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cant_edit_photo'), 'Você não pode editar esta foto.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_hv_already_rated_photo'), 'Você já avaliou esta foto.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_rate_disabled'), 'Avaliação da foto está desativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'need_photo_details'), 'Precisa-se de detalhes da foto.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'embedding_is_disabled'), 'A incorporação foi desativada pelo usuário.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_activated'), 'A foto foi ativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_deactivated'), 'A foto foi desativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_featured'), 'A foto foi marcada como em destaque.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_unfeatured'), 'A foto não está mais em destaque.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_updated_successfully'), 'A foto foi atualizada com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'success_delete_file'), '%s arquivos foram excluídos com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_watermark_found'), 'Não foi possível encontrar arquivo de marca d\'água.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'watermark_updated'), 'Marca d\'água atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_png_watermark'), 'Por favor, envie arquivo PNG 24-bit.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_non_readable'), 'A foto não está legível.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'wrong_mime_type'), 'Tipo MIME errado fornecido.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_have_photos'), 'Você não tem nenhuma foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_have_fav_photos'), 'Você não tem nenhuma foto favorita');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_orphan_photos'), 'Gerenciar fotos órfãs');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_favorite_photos'), 'Gerenciar fotos favoritas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_photos'), 'Gerenciar fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_have_orphan_photos'), 'Você não tem nenhuma foto órfã');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'item_not_exist'), 'O item não existe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_not_exist'), 'A coleção não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'selected_collects_del'), 'As coleções selecionadas foram excluídas.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_collections'), 'Gerenciar coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_categories'), 'Gerenciar categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'flagged_collections'), 'Coleções sinalizadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'create_collection'), 'Criar coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'selected_items_removed'), '%s selecionados foram removidos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'edit_collection'), 'Editar coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_collection_items'), 'Gerenciar itens da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_favorite_collections'), 'Gerenciar coleções favoritas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_fav_collection_removed'), '%s coleções foram removidas dos favoritos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_photos_deleted'), '%s fotos foram excluídas com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_fav_photos_removed'), '%s fotos foram removidas dos favoritos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photos_upload'), 'Enviar foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_items_found_in_collect'), 'Nenhum item encontrado nesta coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_items'), 'Gerenciar Itens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_new_collection'), 'Adicionar nova coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update_collection'), 'Atualizar coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update_photo'), 'Atualizar foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_collection_found'), 'Você não tem nenhuma coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_title'), 'Título da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_caption'), 'Legenda da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_tags'), 'Tags de Fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection'), 'Coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo'), 'Foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video'), 'vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pic_allow_embed'), 'Ativar incorporação de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pic_dallow_embed'), 'Desativar incorporação de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pic_allow_rating'), 'Ativar avaliação de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pic_dallow_rating'), 'Desativar avaliação de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_more'), 'Adicionar mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_name_er'), 'O nome da coleção está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_descp_er'), 'A descrição da coleção está vazia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_tag_er'), 'As tags da coleção estão vazias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_cat_er'), 'Selecione a categoria de coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_borad_pub'), 'Tornar a coleção pública');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_allow_public_up'), 'Envio Público');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_pub_up_dallow'), 'Proibir que outros usuários adicionem itens.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_pub_up_allow'), 'Permitir que outros usuários adicionem itens.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_name'), 'Nome da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_description'), 'Descrição da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_tags'), 'Tags da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_category'), 'Categoria da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_added_msg'), 'A coleção foi adicionada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_not_exist'), 'A coleção não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_upload_opt'), 'Nenhuma opção de upload permitida por {title}, por favor, contate o administrador do site.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photos'), 'Fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cat_all'), 'Todos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_desktop_msg'), 'Envie vídeos diretamente da sua área de trabalho e compartilhe-os online com a nossa comunidade ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_remote_video_msg'), 'Enviar vídeos de outros sites ou servidores, simplesmente insira sua URL e clique em Enviar ou você pode inserir a URL do Youtube e clique em Resgatar do YouTube para enviar o vídeo diretamente do youtube sem inserir seus detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'embed_video_msg'), 'Incorporar vídeos de diferentes sites usando seus \"codigo e imcorporação de vídeo\", basta inserir o código incorporado, insira a duração do vídeo e selecione uma miniatura, preencha os detalhes necessários e clique em enviar.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'link_video_msg'), 'Se você gostaria de fazer o envio de um vídeo sem ter que esperar a conclusão da etapa de envio simplesmente coloque o URL do seu vídeo aqui juntamente com outros detalhes e aproveite.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'browse_photos'), 'Explorar fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_is_saved_now'), 'A coleção de fotos foi salva');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_success_heading'), 'A coleção de fotos foi atualizada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'share_embed'), 'Compartilhado / Incorporado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'item_added_in_collection'), '%s foi adicionado com sucesso na coleção.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'object_exists_collection'), '%s já existe na coleção.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_tag_hint'), 'foto horizontal, Ate classica, rico em detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_broad_pri'), 'Tornar a coleção privada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_item_removed'), '%s foi removido da coleção.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'most_downloaded'), 'Mais baixados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_videos'), 'Total de vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_featured'), 'Coleção destacada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_unfeatured'), 'Coleção removida dos destaque.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_right_guide_photo'), '<strong>Importante: Não envie nenhuma foto que possa ser interpretada como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que estas fotos não violam os <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Termos de Uso do nosso site</span></a> e que você possui todos os direitos autorais destas fotos ou tem autorização para fazer o seu envio.</p>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_right_guide_vid'), '<strong>Importante: Não carregue nenhum vídeo que possa ser interpretado como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que estes vídeos não violam os <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Termos de Uso do nosso site</span></a> e que você possui todos os direitos autorais destes vídeos ou tem autorização para fazer o seu envio.</p>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_deactivated'), 'Coleção desativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_activated'), 'Coleção ativada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_updated'), 'Coleção atualizada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cant_edit_collection'), 'Você não pode editar esta coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'object_not_in_collect'), '%s não existe nesta coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'object_does_not_exists'), '%s não existe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cant_perform_action_collect'), 'Você não pode executar tais ações nesta coleção.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_deleted'), 'Coleção excluída com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_not_exists'), 'A coleção não existe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_items_deleted'), 'Itens da coleção excluídos com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_title_err'), 'Por favor, digite um título válido para a foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'rand_photos'), 'Fotos aleatórias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'this_has_set_profile_item'), 'Este %s foi definido como seu item de perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'profile_item_removed'), 'O item do perfil foi removido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'make_profile_item'), 'Tornar item do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remove_profile_item'), 'Remover item do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'content_type_empty'), 'O Tipo de Conteúdo está vazio. Por favor nos informe o tipo de conteúdo que você quer.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'watch_video_page'), 'Assistir na página do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'watch_on_photo_page'), 'Assistir na página da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'found_no_videos'), 'Nenhum vídeo encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'found_no_photos'), 'Nenhuma foto encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collections'), 'Coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'related_videos'), 'Vídeos Relacionados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'this_video_found_in_no_collection'), 'Este vídeo foi encontrado nas seguintes coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'more_from'), 'Mais de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'this_collection'), 'Coleção : %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_broadcast_unlisted'), 'Não listado (qualquer um com o link e/ou senha pode visualizar)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_link'), 'Link do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'channel_settings'), 'Configurações do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'channel_account_settings'), 'Configurações do canal e conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'account_settings'), 'Configurações da conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'allow_subscription'), 'Permitir inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'allow_subscription_hint'), 'Permitir que membros se inscrevam no seu canal?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'channel_title'), 'Título do Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'channel_desc'), 'Descrição do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_my_friends'), 'Mostrar meus amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_my_videos'), 'Mostrar meus vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_my_photos'), 'Mostrar minhas fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_my_subscriptions'), 'Mostrar minhas inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_my_subscribers'), 'Mostrar meus inscritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'profile_basic_info'), 'Informações básicas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'profile_education_interests'), 'Educação, Hobbies, etc');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'channel_profile_settings'), 'Configurações de canal e perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_my_collections'), 'Exibir as minhas coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_doesnt_any_collection'), 'Usuário não tem nenhuma coleção.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'unsubscribe'), 'Desinscrever-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_have_already_voted_channel'), 'Você já avaliou neste canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'channel_rating_disabled'), 'A votação do canal está desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_activity'), 'Atividade do usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_view_profile'), 'Você não tem permissão para visualizar este canal :/');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'only_friends_view_channel'), 'Somente amigos de %s podem ver este canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collect_type'), 'Tipo da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_to_my_collection'), 'Adicionar isto à minha coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_collections'), 'Total de coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_photos'), 'Total de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'comments_made'), 'Comentários feitos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'block_users'), 'Bloquear usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'tp_del_confirm'), 'Tem certeza que deseja excluir esse tópico?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_need_owners_approval_to_view_group'), 'Você precisa de aprovação de proprietários para visualizar este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cannot_rate_own_collection'), 'Você não pode avaliar sua própria coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_rating_not_allowed'), 'A classificação da coleção agora é permitida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_rate_own_video'), 'Você não pode avaliar seu próprio vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_rate_own_channel'), 'Você não pode avaliar seu próprio canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cannot_rate_own_photo'), 'Você não pode avaliar sua própria foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cant_pm_banned_user'), 'Você não pode enviar mensagens privadas para %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_are_not_allowed_to_view_user_channel'), 'Você não tem permissão para ver o canal de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_send_pm_yourself'), 'Você não pode enviar mensagens privadas para si mesmo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_confimation_ode'), 'Por favor, digite o código de verificação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_brd_confidential'), 'Confidencial (Apenas para usuários especificados)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_password'), 'Senha do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'set_video_password'), 'Digite a senha de vídeo para torná-lo \"protegido por senha\"');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_pass_protected'), 'Este vídeo é protegido por senha, você deve inserir uma senha válida para ver este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_video_password'), 'Por favor, insira uma senha válida para assistir a este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_is_password_protected'), '%s está protegido por senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'invalid_video_password'), 'Senha do vídeo inválida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'logged_users_only'), 'Logado apenas (somente usuários logados podem assistir)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'specify_video_users'), 'Digite um nome de usuário que pode assistir a este vídeo, separado por vírgula');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_users'), 'Usuários do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'not_logged_video_error'), 'Você não pode assistir a este vídeo porque não está logado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_user_subscribed_to_uploader'), 'Nenhum usuário se inscreveu em %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'subs_email_sent_to_users'), 'E-mail de inscrição foi enviado para %s usuário%s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_has_uploaded_new_photo'), '%s enviou uma nova foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_provide_valid_userid'), 'informe um ID de usuário válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_joined_us'), '%s juntou-se a %s , disse olá para %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_has_uploaded_new_video'), '%s enviou um novo vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_has_created_new_group'), '%s criou um novo grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'total_members'), 'Total de membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'watch_video'), 'Assista ao vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_photo'), 'Ver foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_has_joined_group'), '%s juntou-se a um novo grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_is_now_friend_with_other'), '%s e %s agora são amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_has_created_new_collection'), '%s criou uma nova coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_collection'), 'Ver a coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_has_favorited_video'), '%s adicionou um vídeo aos favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'activity'), 'Atividade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_activity'), '%s não possui atividades recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'feed_has_been_deleted'), 'Feed de atividades foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_del_this_feed'), 'Você não pode excluir este feed');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_cant_sub_yourself'), 'Você não pode se inscrever em seu proprio canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_my_album'), 'Gerenciar meu álbum');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_have_permission_to_update_this_video'), 'Você não tem permissão para atualizar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'group_is_public'), 'O grupo é público');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_thumb'), 'Miniatura da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_is_private'), 'A Coleção é privada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'edit_type_collection'), 'Editando %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'comm_disabled_for_collection'), 'Comentários desativados nesta coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'share_this_type'), 'Compartilhar este %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'seperate_usernames_with_comma'), 'Separe nomes de usuário com vírgula');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_all'), 'Visualizar tudo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'album_privacy_updated'), 'A privacidade do álbum foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_have_any_videos'), 'Você não tem nenhum vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update_blocked_use'), 'A lista de usuários bloqueada foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_have_fav_collections'), 'Você não tem nenhuma coleção favorita');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remote_play'), 'Reprodução remota');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'remote_upload_example'), 'ex. http://sitedeenvio.com/exemplo.flv http://www.youtube.com/watch?v=QfRHfquzM0');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update_blocked_user_list'), 'Atualizar lista de usuários bloqueados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'group_is_private'), 'O grupo é privado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_user_associated_with_email'), 'Nenhum usuário está associado a este endereço de e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'pass_changed_success'), '<div class=\"simple_container\">\n    \t<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">A senha foi alterada, por favor, verifique seu e-mail</h2>     \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 11px;\">Sua senha foi alterada com sucesso, por favor, verifique sua caixa de entrada para converir a senha recém-gerada, assim que você acessar a sua conta, altere a sua senha clicando em Mudar a senha.</p>\n </div>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_as_friend'), 'Adicionar como Amigo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'block_user'), 'Bloquear usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_item_was_selected_to_delete'), 'Nenhum item foi selecionado para excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_items_have_been_removed'), 'Os itens da lista de reprodução foram removidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_not_grp_mem_or_approved'), 'Você não entrou ou não é um membro aprovado deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_playlist_was_selected_to_delete'), 'Selecione uma lista de reprodução primeiro.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'featured_videos'), 'Vídeos em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'recent_videos'), 'Vídeos recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'featured_users'), 'Usuários em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'top_collections'), 'Top coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'top_playlists'), 'Top Playlists');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'load_more'), 'Carregar mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_playlists'), 'Nenhuma lista de reprodução encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'featured_photos'), 'Fotos em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_channel_found'), 'Nenhum canal encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'download'), 'Baixar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_to'), 'Adicionar a');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'player_size'), 'Tamanho do Player');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'small'), 'Pequeno');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'medium'), 'Médio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'large'), 'Grande');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'iframe'), 'Iframe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'embed_object'), 'Objeto Incorporado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_to_my_favorites'), 'Adicionar aos favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_select_playlist'), 'Por favor, selecione o nome da lista de reprodução a seguir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'create_new_playlist'), 'Criar uma nova lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'select_playlist'), 'Selecionar da lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'report_video'), 'Denunciar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'report_text'), 'Por favor, selecione a categoria que reflete mais de perto sua preocupação com o vídeo, para que possamos revê-lo e determinar se ele viola as nossas Diretrizes Comunitárias ou se não é apropriado para todos os telespectadores. Abusar deste recurso é também uma violação das Diretrizes Comunitárias, por isso não o faça. ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'flag_video'), 'Sinalizar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'comment_as'), 'Comente como');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'more_replies'), 'Mais respostas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_description'), 'Descrição da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'flag'), 'Sinalizar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update_cover'), 'Atualizar capa');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'unfriend'), 'Desfazer Amizade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'accept_request'), 'Aceitar solicitação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'online'), 'Online');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'offline'), 'Offline');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_video'), 'Enviar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_photo'), 'Enviar foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_beats_guide'), '<strong>Importante: Não carregue nenhum áudio que possa ser interpretado como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que esses áudios não violam os Termos de Uso de Nosso Site e que você possui todos os direitos autorais desses áudios ou tem autorização para fazer o seu envio.</p>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'admin_area'), 'Área do Administrador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_channels'), 'Ver canais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'my_channel'), 'Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'manage_videos'), 'Gerenciar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'cancel_request'), 'Cancelar solicitação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'contact'), 'Contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_featured_videos_found'), 'Nenhum vídeo em destaque encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_recent_videos_found'), 'Nenhum vídeo recente encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_collection_found_alert'), 'Nenhuma coleção encontrada! Você deve criar uma coleção antes de enviar qualquer foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'select_collection_upload'), 'Selecionar coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_collection_upload'), 'Nenhuma coleção encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'create_new_collection_btn'), 'Criar uma nova coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_upload_tab'), 'Enviar foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_videos_found'), 'Nenhum vídeo encontrado!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'Latest_Videos'), 'Vídeos mais recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'Videos_Details'), 'Detalhes dos Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'option'), 'Opção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'flagged_obj'), 'Objetos Sinalizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'watched'), 'Assistido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'since'), 'desde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'last_Login'), 'Última Conexão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_friends_in_list'), 'Você não tem amigos na sua lista');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_pending_friend'), 'Nenhum pedido de amizade pendente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'hometown'), 'Cidade natal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'city'), 'Cidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'schools'), 'Escolas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'occupation'), 'Ocupação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'you_dont_have_videos'), 'Você não tem vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'write_msg'), 'Escrever mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'content'), 'Conteúdo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_video'), 'Nenhum vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'back_to_collection'), 'Voltar para Coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'long_txt'), 'Todas as fotos enviadas são dependentes de suas coleções/álbuns. Ao remover alguma foto de coleção/álbum, isto não vai excluir a foto de forma permanente. Isto irá mover a foto daqui. Você também pode usar isto para tornar suas fotos privadas. O link direto está disponível para compartilhamento com seus amigos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'make_my_album'), 'Criar meu álbum');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'public'), 'Público');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'private'), 'Privado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'for_friends'), 'Para Amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'submit_now'), 'Enviar Agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'drag_drop'), 'Arraste &amp; solte arquivos aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_more_videos'), 'Envie mais vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'selected_files'), 'Arquivos Selecionados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_in_progress'), 'Envio em andamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'complete_of_video'), 'Conclusão do Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_videos'), 'Vídeos da lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'popular_videos'), 'Vídeos populares');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'uploading'), 'Enviando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'select_photos'), 'Selecionar fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'uploading_in_progress'), 'Envio em andamento ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'complete_of_photo'), 'Completo da Foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_more_photos'), 'Envie mais fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'save_details'), 'Salvar Detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'related_photos'), 'Fotos Relacionadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_photos_found'), 'Nenhuma foto encontrada !');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'search_keyword_feed'), 'Pesquisar palavra-chave aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'contacts_manager'), 'Gerenciador de Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'weak_pass'), 'A senha é fraca');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'create_account_msg'), 'Junte-se para começar a compartilhar vídeos e fotos. Leva apenas alguns minutos para criar a sua conta gratuita');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'get_your_account'), 'Criar Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'type_password_here'), 'Digite a senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'type_username_here'), 'Digite um nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'terms_of_service'), 'Termos de Serviço');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'upload_vid_thumb_msg'), 'Miniaturas carregadas com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'agree'), 'Eu concordo com os');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'terms'), 'Termos de Serviço');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'and'), 'e');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'policy'), 'Política de Privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'watch'), 'Assistir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'edit_video'), 'Editar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'del_video'), 'Excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'successful'), 'Sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'processing'), 'Processando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'last_one'), 'Ultimo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'creating_collection_is_disabled'), 'A criação de coleção foi desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'creating_playlist_is_disabled'), 'A criação de lista de reprodução está desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'inactive'), 'Inativo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_actions'), 'Ações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_ph'), 'Ver');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'edit_ph'), 'Editar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'delete_ph'), 'Excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'title_ph'), 'Título');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'view_edit_playlist'), 'Ver/Editar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_playlist_found'), 'Nenhuma lista de reprodução encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_owner'), 'Dono');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_privacy'), 'Privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'add_to_collection'), 'Adicionar à coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_added_to_playlist'), 'Este vídeo foi adicionado à lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'subscribe_btn'), 'Inscrever-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'report_usr'), 'Denunciar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'un_reg_user'), 'Usuário não registrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'my_playlists'), 'Minhas listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'play'), 'Reproduzir agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_vid_in_playlist'), 'Nenhum vídeo encontrado nesta lista de reprodução!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'website_offline'), 'ATENÇÃO: ESTE SITE ESTÁ NO MODO OFFLINE');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'loading'), 'Carregando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'hour'), 'hora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'hours'), 'horas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'day'), 'dia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'days'), 'dias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'week'), 'semana');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'weeks'), 'semanas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'month'), 'mês');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'months'), 'meses');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'year'), 'ano');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'years'), 'anos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'decade'), 'década');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'decades'), 'décadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'your_name'), 'Seu nome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'your_email'), 'Seu e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'type_comment_box'), 'Por favor, digite algo na caixa de comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'guest'), 'Visitante');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'anonymous'), 'Anônimo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_comment_added'), 'Nenhum comentário adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'register_min_age_request'), 'Você deve ter pelo menos %s anos de idade para registrar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'select_category'), 'Por favor, selecione sua categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'custom'), 'Personalizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_playlist_exists'), 'Não existe nenhuma lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'edit'), 'Editar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'create_new_account'), 'Criar uma nova conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'search_too_short'), 'Consulta de pesquisa %s é muito curta. Abra!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_allow_comments'), 'Permitir comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_allow_rating'), 'Permitir avaliação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlist_description'), 'Descrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'playlists_have_been_removed'), 'As Listas de reprodução foram removidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'confirm_collection_delete'), 'Você realmente quer excluir esta coleção ?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_select_collection'), 'Por favor, selecione o nome da coleção a seguir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'please_enter_collection_name'), 'Por favor, insira o nome da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'select_collection'), 'Selecione da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'resolution'), 'Resolução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'filesize'), 'Tamanho do arquivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'empty_next'), 'A lista de reprodução atingiu o seu limite!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'no_items'), 'Não há itens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_recover_user'), 'Esqueceu o Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'edited_by'), 'editado por');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'reply_to'), 'Responder a');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'mail_type'), 'Tipo de email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'host'), 'Servidor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'port'), 'Porta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user'), 'Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'auth'), 'Autenticação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'mail_not_send'), 'Não foi possível enviar o e-mail <strong>%s</strong>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'mail_send'), 'E-mail enviado com sucesso para <strong>%s</strong>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'title'), 'Título');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'show_comments'), 'Mostrar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'hide_comments'), 'Ocultar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'description'), 'Descrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'users_categories'), 'Categorias de Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'popular_users'), 'Usuários Populares');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'channel'), 'Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'embed_type'), 'Tipo de Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'confirm_del_photo'), 'Você tem certeza que deseja excluir esta foto?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'vdo_inactive'), 'O vídeo está inativo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_tags_error'), 'Por favor, especifique tags para a Foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'signups'), 'Cadastros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'active_users'), 'Usuários Ativos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'uploaded'), 'Enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'user_name_invalid_len'), 'Comprimento do usuário é inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'username_spaces'), 'O nome de usuário não pode conter espaços');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_caption_err'), 'Digite a descrição da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_tags_err'), 'Por favor, digite Tags Para a Foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'photo_collection_err'), 'Você deve especificar uma coleção para esta foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'details'), 'Detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'technical_error'), 'Ocorreu um erro técnico!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'inserted'), 'Inserido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'castable_status_fixed'), 'O Estado de Transmitido de %s foi corrigido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'castable_status_failed'), '%s não pode ser transmitido corretamente porque tem %s canais de áudio, por favor, reconverta o vídeo com opção chromecast ativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'castable_status_check'), 'Verificar Estado de Transmitivel');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'castable'), 'Transmitível');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'non_castable'), 'Não-Transmissível');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'videos_manager'), 'Gerenciador de vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'update_bits_color'), 'Atualizar cores de bits');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'bits_color'), 'cores dos bits');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'bits_color_compatibility'), 'O formato de vídeo torna isso impossível de reproduzir em alguns navegadores como Firefox, Safari, ...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'player_logo_reset'), 'O logo do player foi redefinido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'player_settings_updated'), 'As configurações do player foram atualizadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'player_settings'), 'Configurações do player');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'quality'), 'Qualidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'error_occured'), 'Ops... Algo de errado aconteceu...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'error_file_download'), 'Falha ao obter o arquivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'dashboard_update_status'), 'Estado da Atualização');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'dashboard_changelogs'), 'Registro de alterações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'dashboard_php_config_allow_url_fopen'), 'Por favor, habilite \'allow_url_fopen\' para beneficiar o relatório de alterações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'signup_error_email_unauthorized'), 'E-mail não permitido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_detail_saved'), 'Os detalhes do vídeo foram salvos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_subtitles_deleted'), 'As legendas do vídeo foram excluídas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_no_parent'), 'Nenhum progenitor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'collection_parent'), 'Coleção parental');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'comments_disabled_for_photo'), 'Comentários desativados para esta foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks'), 'Escolha do Editor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_added'), 'O vídeo foi adicionado à Escolha do Editor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed'), 'O vídeo foi removido da Escolha do Editor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_removed_plural'), 'O vídeo selecionado foi removido da Escolha do Editor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_error'), 'O vídeo já está na Escolha do Editor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_add_to'), 'Adicionar à Escolha do Editor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_from'), 'Remover da Escolha do Editor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_editors_picks_remove_confirm'), 'Tem certeza de que deseja remover os vídeos selecionados da Escolha do Editor?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement'), 'Anúncio Global');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_subtitle'), 'Gerenciador de Anúncios Globais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_edit'), 'Editar anúncio global');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'plugin_global_announcement_updated'), 'O anúncio global foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_upload_video_limits'), 'Cada vídeo não pode exceder %s MB de tamanho ou %s minutos de duração e deve estar em um formato de vídeo comum');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_upload_video_select'), ' Selecionar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'page_upload_photo_limits'), 'Cada foto não pode exceder %s MB de tamanho e deve estar em um formato de imagem comum');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_resolution_auto'), 'Automático');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_thumbs_regenerated'), 'As miniaturas do vídeo foram regeneradas com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'video_allow_comment_vote'), 'Permitir votos nos comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key LIKE 'code'), 'Código');
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'admin_tool'), 'Ferramentas Administrativas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'launch'), 'Iniciar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'stop'), 'Parar', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'in_progress'), 'Em progresso', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'ready'), 'Pronto', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'stopping'), 'Parando', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'generate_missing_thumbs_label'), 'Gerar miniaturas faltantes', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'generate_missing_thumbs_description'), 'Gerar miniaturas para os vídeos sem uma miniatura', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_castable_status_label'), 'Atualizar status de vídeos transmissíveis', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_castable_status_description'), 'Atualize o status de todos os vídeos que podem ser transmitidos com base nos arquivos de vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_bits_color_label'), 'Atualizar status de codificação de cores dos vídeos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_bits_color_description'), 'Atualize o status de codificação de cores de todos os vídeos, com base nos arquivos de vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_videos_duration_label'), 'Atualizar as durações dos vídeos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_videos_duration_description'), 'Atualize todas as durações dos vídeos, com base nos arquivos de vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'need_db_upgrade'), 'Você tem <b>%s</b> arquivos para executar para poder atualizar seu banco de dados. Você pode usar este link a seguir: ', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'db_up_to_date'), 'Seu banco de dados está atualizado', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_database_version_label'), 'Atualizar seu banco de dados para a versão atual', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'update_database_version_description'), 'Execute todos os arquivos SQL necessários para atualizar o banco de dados', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'no_version'), 'Seu ClipBucket usa o antigo sistema de atualização de banco de dados. Execute todos os arquivos de migração SQL para a versão 5.3.0 antes de continuar.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'select_version'), 'Por favor, selecione sua versão atual e a revisão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'version'), 'versão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'revision'), 'revisão', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'system_info'), 'Informações do Sistema', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'hosting'), 'Hospedagem', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_ffmpeg'), 'é usado para converter vídeos de diferentes versões para FLV, MP4 e muitos outros formatos.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'tool_box'), 'Caixa de Ferramentas', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_php_cli'), 'é usado para realizar a conversão de vídeo em um processo em segundo plano.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_media_info'), 'fornece informações técnicas e de marcação sobre um arquivo de vídeo ou áudio.', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_ffprobe'), 'é uma extensão do FFMPEG usada para obter informações do arquivo de mídia', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'info_php_web'), 'é usado para exibir esta página', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'must_be_least'), 'deve ser pelo menos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'php_cli_not_found'), 'PHP CLI não está configurado corretamente', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'cache'), 'cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'enable_cache'), 'Ativar cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'enable_cache_authentification'), 'Ativar autenticação de cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_cache_label'), 'Redefinir Cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'reset_cache_description'), 'Limpar todas as entradas do cache', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'nb_files'), 'Numero de arquivos', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'video_file_management'), 'Gerenciamento de arquivos de vídeo', @language_id);
INSERT INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` LIKE 'confirm_delete_video_file'), 'Tem certeza de que deseja excluir a resolução %sp ?', @language_id);
