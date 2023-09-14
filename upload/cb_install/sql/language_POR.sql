INSERT INTO `{tbl_prefix}languages` (`language_name`, `language_active`, `language_default`, `language_code`)
VALUES ('Portuguesa', 'yes', 'no', 'pt-BR');

SET @language_id = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');

INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_name_error'), 'Por favor, insira um nome para o anúncio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ad_code_error'), 'Erro : Por favor, digite o código para o anúncio');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_img_error'), 'Por favor, carregue apenas imagens JPEG, GIF ou PNG');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_exist_error'), 'A categoria não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_add_msg'), 'Categoria foi adicionada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_update_msg'), 'A categoria foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_err'), 'O Grupo Não Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_fr_msg'), 'O grupo foi definido como destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_fr_msg1'), 'Os Grupos Selecionados Foram Removidos da Lista de Destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_ac_msg'), 'Os Grupos Selecionados Foram Ativados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_dac_msg'), 'Os Grupos Selecionados Foram Desativados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_del_msg'), 'O grupo foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'editor_pic_up'), 'O vídeo foi movido para cima');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'editor_pic_down'), 'Vídeo foi movido para baixo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_name_error'), 'Digite o nome do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_name_error1'), 'Nome de grupo já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_des_error'), 'Por favor, insira uma Pequena Descrição para o Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tags_error'), 'Por favor, digite Tags para o Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_url_error'), 'Por favor, insira um URL válido para o Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_url_error1'), 'Por favor, insira um nome de URL válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_url_error2'), 'URL de grupo já existe, por favor escolha uma URL diferente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tpc_error'), 'Por favor, insira um tópico para adicionar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_comment_error'), 'Você deve digitar um comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_join_error'), 'Você já entrou neste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_prvt_error'), 'Este grupo é privado, faça o login para visualizar este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_inact_error'), 'Este grupo está inativo, por favor contate o administrador para este problema');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_join_error1'), 'Você ainda não se juntou a este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_exist_error'), 'Desculpe, o Grupo não Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tpc_error1'), 'Este tópico não foi aprovado pelo proprietário do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_cat_error'), 'Selecione uma categoria para o seu grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tpc_error2'), 'Por favor, insira um tópico para adicionar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tpc_error3'), 'Seu tópico requer aprovação do proprietário deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tpc_msg'), 'O tópico foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_comment_msg'), 'O comentário foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_vdo_msg'), 'Vídeos excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_vdo_msg1'), 'Vídeos adicionados com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_vdo_msg2'), 'Os vídeos foram aprovados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_mem_msg'), 'O membro foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_mem_msg1'), 'O membro foi aprovado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_inv_msg'), 'Seu convite foi enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tpc_msg1'), 'O tópico foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tpc_msg2'), 'Tópico foi aprovado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_fr_msg2'), 'O grupo foi removido da lista de destaques');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_inv_msg1'), 'Convidou você para se juntar ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_av_msg'), 'O grupo foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_da_msg'), 'O grupo foi desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_post_msg'), 'A Postagem foi excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_update_msg'), 'O grupo foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_owner_err'), 'Apenas o proprietário pode adicionar vídeos a este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_owner_err1'), 'Você não é dono deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_owner_err2'), 'Você é dono deste grupo. Você não pode sair do seu grupo.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_prvt_err1'), 'Este grupo é privado, você precisa de convite de seu proprietário para entrar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_rmv_msg'), 'Os Grupos Selecionados foram Removidos da Sua Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tpc_err4'), 'Desculpe, Tópico não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_title_topic'), 'Grupos - Tópico - ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_add_title'), '- Adicionar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_sadmin_err'), 'Você não pode deixar o nome de usuário do SuperAdmin em branco');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cpass_err'), 'A senha de confirmação não corresponde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_err'), 'A senha antiga está incorreta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_email_err'), 'Por favor, forneça um endereço de e-mail válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cpass_err1'), 'Confirmação de senha incorreta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_err1'), 'A senha está incorreta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cmt_err'), 'Você precisa fazer login primeiro para comentar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cmt_err1'), 'Por favor, digite algo na Caixa de Comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cmt_err2'), 'Você não pode comentar em seu vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cmt_err3'), 'Você já postou um comentário neste canal.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cmt_err4'), 'O comentário foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cmt_del_msg'), 'O comentário foi excluido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cmt_del_err'), 'Ocorreu um erro ao remover o comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cnt_err'), 'Você não pode se adicionar como um contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cnt_err1'), 'Você já adicionou este usuário à sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_sub_err'), 'Você já está inscrito em %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_exist_err'), 'O usuário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ccode_err'), 'O código de verificação inserido está errado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_exist_err1'), 'Desculpe, nenhum usuário existe com este e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_exist_err2'), 'Desculpe, o usuário não existe');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pcode_err'), 'Códigos postais contêm apenas números');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_fname_err'), 'O nome está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_lname_err'), 'O último nome está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_err3'), 'Nome de usuário contém caracteres não permitidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_err3'), 'Senhas não Correspondentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_dob_err'), 'Selecione a data de nascimento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ament_err'), 'Desculpe, você precisa concordar com os termos de uso e política de privacidade para criar uma conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_reg_err'), 'Desculpe, os registros não estão permitidos temporariamente. Por favor, tente novamente mais tarde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ban_err'), 'Conta de usuário banida, entre em contato com o administrador do site');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_login_err'), 'Nome de usuário e senha não correspondem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_sadmin_msg'), 'Super Administrador foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_msg'), 'Sua senha foi alterada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_cnt_msg'), 'Este usuário foi adicionado à sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_sub_msg'), 'Você agora é um inscrito de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_email_msg'), 'Enviamos um e-mail para você contendo seu nome de usuário, por favor verifique-o');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_rpass_email_msg'), 'Um e-mail foi enviado para você. Siga as instruções lá para redefinir sua senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_email_msg'), 'A senha foi alterada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_email_msg'), 'As configurações de e-mail foram atualizadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_del_msg'), 'O usuário foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_dels_msg'), 'Os usuários selecionados foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ac_msg'), 'O usuário foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_dac_msg'), 'O usuário foi desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_mem_ac'), 'Os Membros Selecionados Foram Ativados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_mems_ac'), 'Os membros selecionados foram desativados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_fr_msg'), 'O usuário foi definido como um membro em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ufr_msg'), 'O Usuário foi removido dos usuários em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_frs_msg'), 'Os usuários selecionados foram definidos como em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ufrs_msg'), 'Os usuários selecionados foram removidos da lista em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uban_msg'), 'O usuário foi banido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uuban_msg'), 'O usuário foi desbanido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_ubans_msg'), 'Os membros selecionados foram banidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uubans_msg'), 'Os membros selecionados foram desbanidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_reset_conf'), 'Confirmação para Redefinição de Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_dear_user'), 'Caro Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_pass_reset_msg'), 'Você solicitou uma redefinição de senha, siga o link para redefinir sua senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_rpass_msg'), 'A senha foi redefinida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_rpass_req_msg'), 'Você solicitou uma redefinição de senha, aqui está a sua nova senha: ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_req_msg'), 'Você solicitou a Recuperação do Seu Nome de Usuário, Aqui está seu Nome de Usuário: ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_uname_recovery'), 'E-mail de recuperação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_add_succ_msg'), 'O usuário foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_upd_succ_msg'), 'O usuário foi atualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_msg'), 'Sua conta foi ativada. Agora você pode fazer login em sua conta e enviar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_err'), 'Este usuário já está ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_em_msg'), 'Enviamos um e-mail contendo o seu código de ativação. Por favor, verifique sua caixa de correio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_em_err'), 'O e-mail não existe ou o usuário com este e-mail já está ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_no_msg_del_err'), 'Nenhuma mensagem foi selecionada para exclusão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_sel_msg_del_msg'), 'As mensagens selecionadas foram excluídas');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_open_marriage'), 'Casamento Aberto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_arr_open_relate'), 'Relacionamento Aberto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_crt_new_msg'), 'Compor Nova Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_forgot'), 'Esqueceu algo? Encontre-o agora!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_inbox'), ' - Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_sent'), '- Pasta de Envios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_usr_contact'), ' Lista de Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_usr_fav_vids'), 'Vídeos Favoritos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'title_edit_video'), 'Editar Vídeo - ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_title_err'), 'Digite o título do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_des_err'), 'Digite a descrição do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_tags_err'), 'Por favor, digite Tags para o Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat_err'), 'Por favor, escolha pelo menos uma categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat_err1'), 'Você só pode escolher até 3 categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_sub_email_msg'), ' e, portanto, esta mensagem é enviada a você automaticamente por que ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_has_upload_nv'), 'Enviou um novo vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_del_selected'), 'Os vídeos selecionados foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cheat_msg'), 'Por favor, não tente trapacear');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_limits_warn_msg'), 'Por favor, não tente cruzar seus limites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cmt_del_msg'), 'O comentário foi excluido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_iac_msg'), 'Vídeo está Inativo - Por favor contate o Administrador para mais detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_is_in_process'), 'Vídeo está sendo processado - por favor contate o administrador para mais detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_upload_allow_err'), 'O envio não é permitido pelo proprietário do site');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_download_allow_err'), 'O download de vídeos não é permitido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_edit_owner_err'), 'Você não é proprietário de vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_embed_code_wrong'), 'Código de incorporação esta errado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_seconds_err'), 'Valor errado inserido no campo de segundos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_mins_err'), 'Valor errado inserido no campo de minutos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_thumb_up_err'), 'Erro ao enviar miniatura');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_comment_err'), 'Você deve logar antes de postar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_comment_err1'), 'Por favor, digite algo na Caixa de Comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_comment_err2'), 'Você não pode publicar um comentário no seu próprio vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_comment_err3'), 'Você já postou um comentário, por favor espere pelos outros.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_comment_err4'), 'Você já respondeu a um comentário, por favor espere pelos outros.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_comment_err5'), 'Você não pode postar uma resposta a si mesmo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_comment_msg'), 'O comentário foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_comment_err6'), 'Por favor, inicie a sessão para avaliar o comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_comment_err7'), 'Você já avaliou este comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_fav_err'), 'Este vídeo já foi adicionado aos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_fav_msg'), 'Este vídeo foi adicionado aos seus favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_flag_err'), 'Você já sinalizou este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_flag_msg'), 'Este vídeo foi sinalizado como inapropriado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_flag_rm'), 'Sinalizador(es) Foi/Foram removido(s)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_send_msg_err'), 'Digite um nome de usuário ou selecione qualquer usuário para enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_invalid_user'), 'Nome de usuário inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_subj_err'), 'Assunto da mensagem está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_msg_err'), 'Por favor, digite algo na caixa de mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_sent_you_msg'), 'Enviou uma mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_sent_prvt_msg'), 'Enviou-lhe uma mensagem privada em ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_click_inbox'), 'Clique aqui para visualizar sua caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_click_login'), 'Clique aqui para entrar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_email_notify'), 'Notificação de Email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_msg_has_sent_to'), 'A mensagem foi enviada para ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_inbox_del_msg'), 'A mensagem foi apagada da caixa de entrada ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_sent_del_msg'), 'A mensagem foi excluída da pasta Enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_msg_exist_err'), 'A Mensagem Não Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_del_err'), 'O vídeo não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_unsub_msg'), 'Sua assinatura foi cancelada com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_sub_exist_err'), 'A assinatura não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_rm_fav_msg'), 'O vídeo foi removido dos favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_fav_err1'), 'Este vídeo não está na sua lista de favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_cont_del_msg'), 'O contato foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_cot_err'), 'Desculpe, este contato não está na sua lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_ep_err1'), 'Você já escolheu 10 vídeos, por favor, exclua um para adicionar mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_vdo_exist_err'), 'Desculpe, o vídeo não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_img_gif_err'), 'Por favor envie apenas imagem Gif');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_img_png_err'), 'Por favor envie apenas uma imagem Png');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_img_jpg_err'), 'Por favor, envie apenas imagem Jpg');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'class_logo_msg'), 'O logotipo foi alterado. Por favor, limpe o cache se você não é capaz de ver o logotipo mudado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_forgot_username'), 'Esqueceu seu Usuário | Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_join_now'), 'Cadastre-se agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_my_account'), 'Minha Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_manage_vids'), 'Gerenciar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_view_channel'), 'Ver Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_my_inbox'), 'Minha Caixa de Entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_welcome'), 'Bem-vindo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_top_mem'), 'Membros populares ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_vidz'), 'Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_sign_up_now'), 'Inscreva-se agora!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_my_videos'), 'Meus Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_my_channel'), 'Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_my_subs'), 'Minhas inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_user_no_contacts'), 'O Usuário não tem qualquer Contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_user_no_vides'), 'O usuário não possui nenhum vídeo favorito');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_user_no_vid_com'), 'O usuário não tem comentários de vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_view_all_contacts'), 'Ver todos os contatos de');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_view_fav_all_videos'), 'Ver todos os vídeos favoritos de');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_login_success_msg'), 'Você foi logado com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_logout_success_msg'), 'Você foi desconectado com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_not_redirecting'), 'Agora você está sendo redirecionando.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_not_redirecting_msg'), 'Se você não estiver sendo redirecionando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_manage_contacts'), 'Gerenciar Contatos ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_manage_fav'), 'Gerenciar Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_manage_subs'), 'Gerenciar Inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_subscribe_to'), 'Inscrever-se no canal de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_total_subs'), 'Total de Inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_total_vids'), 'Total de vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_date_subscribed'), 'Data da Inscrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_search_results'), 'Resultados da busca');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_advance_results'), 'Busca avançada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'com_search_results_in'), 'Resultados da Pesquisa em');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'videos_being_watched'), 'Visualizados Recentemente...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'latest_added_videos'), 'Adições Recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_viewed'), 'Mais Vistos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'recently_added'), 'Adicionado Recentemente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'featured'), 'Em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'highest_rated'), 'Melhor avaliado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_discussed'), 'Mais discutidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'style_change'), 'Alteração de Estilo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'rss_feed_latest_title'), 'RSS feed para vídeos mais recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'rss_feed_featured_title'), 'RSS feed para vídeos em destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'rss_feed_most_viewed_title'), 'Feed RSS para vídeos mais populares');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_folder'), 'pt-br');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'reg_closed'), 'Registro fechado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'reg_for'), 'Cadastramento para');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'is_currently_closed'), 'está atualmente fechado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'about_us'), 'Sobre nós');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'account'), 'Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'added'), 'Adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'advertisements'), 'Anúncios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'all'), 'Todos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'active'), 'Ativo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'activate'), 'Ativar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'deactivate'), 'Desativar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'age'), 'Idade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'approve'), 'Aprovar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'approved'), 'Aprovado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'approval'), 'Aprovação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'books'), 'Livros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'browse'), 'Navegar');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'check_all'), 'Marcar todos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'click_here'), 'Clique Aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comments'), 'Comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comment'), 'Comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'community'), 'Comunidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'companies'), 'Empresas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'contacts'), 'Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'contact_us'), 'Contate-nos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'country'), 'País');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'created'), 'Criado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date'), 'Data');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date_added'), 'Data de Adição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date_joined'), 'Data de inscrição');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'dear'), 'Caro(a)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete'), 'Excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add'), 'Adicionar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete_selected'), 'Excluir Selecionados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'des_title'), 'Descrição:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'duration'), 'Duração');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'education'), 'Educação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email'), 'E-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'embed'), 'Incorporar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'embed_code'), 'Código de Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'favourite'), 'Favorito');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'favourited'), 'Adicionado aos Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'favourites'), 'Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'female'), 'Mulher');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'filter'), 'Filtro');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'forgot'), 'Esqueci');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friends'), 'Amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'from'), 'De');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'gender'), 'Sexo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'groups'), 'Grupos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hello'), 'Olá');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'help'), 'Ajuda');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hi'), 'Olá');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'hobbies'), 'Passatempos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'Home'), 'Início');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'inbox'), 'Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'interests'), 'Interesses');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'join_now'), 'Junte-se agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'joined'), 'Juntou-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'join'), 'Juntar-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'keywords'), 'Palavras-chave');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'latest'), 'Recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'leave'), 'Sair');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_members'), 'Mais Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_recent'), 'Mais Recente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_videos'), 'Mais vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'music'), 'Música');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_account'), 'Minha Conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'next'), 'Próxima');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no'), 'Não');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_user_exists'), 'Nenhum Usuário Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_video_exists'), 'Nenhum Vídeo Existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'occupations'), 'Ocupações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'optional'), 'opcional');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'owner'), 'Dono');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'password'), 'senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please'), 'Por favor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'privacy'), 'Privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'privacy_policy'), 'Política de Privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'random'), 'Aleatório');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'rate'), 'Avalie');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'request'), 'Solicitar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'related'), 'Relacionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'reply'), 'Responder');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'results'), 'Resultados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'relationship'), 'Relacionamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'second'), 'segundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'seconds'), 'segundos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'select'), 'Selecionar');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'times'), 'Tempos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'to'), 'Para');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type'), 'Tipo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update'), 'Atualizar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload'), 'Enviar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'url'), 'URL');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'verification'), 'Verificação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'videos'), 'Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'viewing'), 'Visualizando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'welcome'), 'Bem-vindo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'website'), 'Página Web');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'yes'), 'Sim');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'of'), 'de');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'on'), 'em');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'previous'), 'Anterior');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'rating'), 'Avaliação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ratings'), 'Avaliações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remote_upload'), 'Envio Remoto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove'), 'Remover');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'search'), 'Pesquisar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'services'), 'Serviços');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_all'), 'Mostrar tudo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signupup'), 'Cadastre-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'sort_by'), 'Ordenar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subscriptions'), 'Inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subscribers'), 'Inscritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'tag_title'), 'Tags');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'track_title'), 'Faixa de áudio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'time'), 'tempo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'top'), 'Topo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'tos_title'), 'Termos de Uso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'username'), 'Nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'views'), 'Visualizações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'proccession_wait'), 'Processando, Por favor, aguarde');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mostly_viewed'), 'Mais Vistos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_comments'), 'Mais comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'group'), 'Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'not_logged_in'), 'Você não está logado ou não tem permissão para acessar esta página. Isto pode ocorrer devido a vários motivos:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'fill_auth_form'), 'Você não está conectado. Preencha o formulário abaixo e tente novamente.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'insufficient_privileges'), 'Você pode não ter privilégios suficientes para acessar esta página.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'admin_disabled_you'), 'O administrador do site pode ter desabilitado sua conta ou pode estar aguardando ativação.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'Recover_Password'), 'Recuperar Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'Submit'), 'Enviar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'Reset_Fields'), 'Limpar campos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'admin_reg_req'), 'O administrador pode ter exigido que você se registre antes de poder ver esta página.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_change'), 'Alterar Idioma');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_changed'), 'Seu idioma foi alterado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_choice'), 'Idioma');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'if_not_redir'), 'Clique aqui para continuar se você não é redirecionado automaticamente.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'style_changed'), 'Seu estilo foi alterado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'style_choice'), 'Estilo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_edit_vdo'), 'Editar Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_stills'), 'Travas de vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_watch_video'), 'Assistir Vídeo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_date_loc'), 'Data e Localização');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_date_rec'), 'Data de gravação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_for_date'), 'formato MM / DD / YYYY ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_add_eg'), 'Exemplo: Gronelândia de Londres, Sialkot Mubarak Pura');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_share_opt'), 'Opções de compartilhamento e privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_allow_comm'), 'Permitir comentários ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_dallow_comm'), 'Não permitir comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_comm_vote'), 'Votação de Comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_allow_com_vote'), 'Permitir votação nos comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_dallow_com_vote'), 'Não permitir nos comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_allow_rating'), 'permitir avaliação neste vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_embedding'), 'Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_embed_opt1'), 'As pessoas podem reproduzir este vídeo em outros sites');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_update_title'), 'Atualizar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_inactive_msg'), 'Sua conta está inativa. Por favor ative-a para fazer upload de vídeos. Para ativar sua conta, por favor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_click_here'), 'Clique Aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_continue_upload'), 'Continuar para o envio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_upload_step1'), 'Envio do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_upload_step2'), 'Etapa do Vídeo %s/2');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_upload_step3'), '(Passo 2/2)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_select_vdo'), 'Selecione um vídeo para enviar.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_enter_remote_url'), 'Digite a URL do vídeo.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_enter_embed_code_msg'), 'Insira o Código de Incorporação do Vídeo de outros sites, ou seja, Youtube ou Metacafe.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_enter_embed_code'), 'Inserir Código de Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_enter_druation'), 'Digite a duração');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_select_vdo_thumb'), 'Selecionar miniatura do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_having_trouble'), 'Está com problemas?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_if_having_problem'), 'se você estiver tendo problemas com o carregador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_clic_to_manage_all'), 'Clique Aqui para Gerenciar Todos os Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_manage_vdeos'), 'Gerenciar Vídeos ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_status'), 'Situação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_rawfile'), 'RawFile');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_video_upload_complete'), 'Envio do Vídeo - Envio Completo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_thanks_you_upload_complete_1'), 'Obrigado! Seu envio foi concluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_thanks_you_upload_complete_2'), 'Este vídeo estará disponível em');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_after_it_has_process'), 'após o processamento ter terminado.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_embed_this_video_on_web'), 'Incorpore este vídeo no seu site.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_copy_and_paste_the_code'), 'Copie e cole o código abaixo para incorporar este vídeo.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_upload_another_video'), 'Enviar outro Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_goto_my_videos'), 'Ir para Meus Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_sperate_emails_by'), 'separe e-mails por vírgulas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_personal_msg'), 'Mensagem Pessoal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_related_tags'), 'Tags Relacionadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_reply_to_this'), 'Responder a este ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_add_reply'), 'Adicionar resposta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_share_video'), 'Compartilhar Vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_about_this_video'), 'Sobre este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_post_to_a_services'), 'Postar em um Serviço Agregador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_commentary'), 'Comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_post_a_comment'), 'Publicar um comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_add_vdo_msg'), 'Adicionar vídeos ao grupo ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_no_vdo_msg'), 'Você não possui nenhum vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_add_to'), 'Adicionar ao grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_add_vdos'), 'Adicionar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_name_title'), 'Nome do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tag_title'), 'Tags:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_des_title'), 'Descrição:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tags_msg'), 'Insira uma ou mais tags, separadas por espaços.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_tags_msg1'), 'Insira uma ou mais tags, separadas por espaços. Tags são palavras-chave usadas para descrever o seu grupo, para que possa ser facilmente encontrado por outros usuários. Por exemplo, se temos um grupo para surfistas, podemos designá-lo: navegar, praia, ondas.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_url_title'), 'Escolha uma URL única para o nome do grupo:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_url_msg'), 'Insira 3-18 caracteres sem espaços (como «skates de skates»), que se tornarão parte do endereço web do seu grupo. Por favor, note que o nome do grupo escolhido é permanente e não pode ser alterado.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_cat_tile'), 'Categoria do Grupo:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_vdo_uploads'), 'Upload de vídeo:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_forum_posting'), 'Publicação no Fórum:');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_join_opt1'), 'Público, qualquer um pode entrar.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_join_opt2'), 'Protegido, requer aprovação do fundador para entrar.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_join_opt3'), 'Privado, apenas por convite do fundador, somente membros podem ver os detalhes do grupo.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_vdo_opt1'), 'Postar vídeos imediatamente.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_vdo_opt2'), 'Aprovação de fundador necessária antes do vídeo estar disponível.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_vdo_opt3'), 'Somente o Fundador pode adicionar novos vídeos.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_post_opt1'), 'Publicar tópicos imediatamente.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_post_opt2'), 'É necessária a aprovação de fundador antes que o tópico esteja disponível.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_post_opt3'), 'Somente o fundador pode criar um novo tópico.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_crt_grp'), 'Criar grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_thumb_title'), 'Miniatura do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_upl_thumb'), 'Enviar Miniatura do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_must_be'), 'Deve ser');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_90x90'), '90  x 90 de tamanho dará a melhor qualidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_thumb_warn'), 'Não Envie Material Vulgar/Pornografico ou Com Direitos Autorais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_del_confirm'), 'Você tem certeza que deseja excluir este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_del_success'), 'Você excluiu com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_click_go_grps'), 'Clique Aqui Para Ir Para Os Grupos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_edit_grp_title'), 'Editar Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_manage_vdos'), 'Gerenciar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_manage_mems'), 'Gerenciar Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_del_group_title'), 'Excluir grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_add_vdos_title'), 'Adicionar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_join_grp_title'), 'Juntar-se ao grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_leave_group_title'), 'Deixar o Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_invite_grp_title'), 'Convidar Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_view_mems'), 'Ver Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_view_vdos'), 'Ver vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_create_grp_title'), 'Criar um novo grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_most_members'), 'Mais Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_most_discussed'), 'Mais discutidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_invite_msg'), 'Convidar usuários para este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_invite_msg1'), 'Convidou você para se juntar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_invite_msg2'), 'Digite os E-mails ou nomes de usuário (separados por vírgulas)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_url_title1'), 'URL do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_invite_msg3'), 'Enviar convite');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_join_confirm_msg'), 'Você tem certeza que quer se juntar a este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_join_msg_succ'), 'Você entrou no grupo com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_click_here_to_go'), 'Clique Aqui para ir para');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_leave_confirm'), 'Você tem certeza que quer sair deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_leave_succ_msg'), 'Você saiu do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_manage_members_title'), 'Gerenciar Membros ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_for_approval'), 'Para aprovação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_rm_videos'), 'Remover Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_rm_mems'), 'Remover Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_groups_title'), 'Gerenciar Grupos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_joined_title'), 'Gerenciar Grupos Cadastrados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_remove_group'), 'Remover Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_bo_grp_found'), 'Nenhum grupo encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_joined_groups'), 'Grupos que Juntou-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_owned_groups'), 'Grupos que é Dono');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_edit_this_grp'), 'Editar este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_topics_title'), 'Tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_topic_title'), 'Tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_posts_title'), 'Postagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_discus_title'), 'Discussões');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_author_title'), 'Autor');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_replies_title'), 'Respostas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_last_post_title'), 'Última postagem ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_viewl_all_videos'), 'Ver todos os vídeos deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_add_new_topic'), 'Adicionar Novo Tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_attach_video'), 'Anexar vídeo ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_add_topic'), 'Adicionar Tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_please_login'), 'Por favor, entre para postar tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_please_join'), 'Por favor, junte-se a este grupo para postar tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_inactive_account'), 'Sua Conta Está Inativa e Requer Ativação do Proprietário do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_about_this_grp'), 'Sobre este grupo ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_no_vdo_err'), 'Este Grupo Não Tem Videos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_posted_by'), 'Publicado por');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_add_new_comment'), 'Adicionar Novo Comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_add_comment'), 'Adicionar Comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_pls_login_comment'), 'Por favor conecte-se para postar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_pls_join_comment'), 'Por favor, junte-se a este grupo para enviar comentários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_title'), 'Ativação do usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_actiavation_msg'), 'Digite seu nome de usuário e código de ativação que foram enviados para seu e-mail.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_actiavation_msg1'), 'Solicitar Código de Ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_activation_code_tl'), 'Código de Ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_compose_msg'), 'Compor Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_inbox_title'), 'Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_sent_title'), 'Enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_to_title'), 'Para: (Digite o nome do usuário)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_or_select_frm_list'), 'ou selecione da lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_attach_video'), 'Anexar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_attached_video'), 'Vídeo anexado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_no_message'), 'Sem Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_delete_message_msg'), 'Excluir esta mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_forgot_message'), 'Esqueci a senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_forgot_message_2'), 'Não se preocupe, recupere-o agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_pass_reset_msg'), 'Redefinir senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_pass_forgot_msg'), 'se você esqueceu sua senha, digite seu nome de usuário e código de verificação na caixa, e instruções para redefinir a senha serão enviadas para sua caixa de correio.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_veri_code'), 'Código de Verificação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_reocover_user'), 'Recuperar Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_user_forgot_msg'), 'Esqueceu o seu nome de usuário?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_recover'), 'Recuperar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_reset'), 'Redefinir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_inactive_msg'), 'Sua conta está inativa, por favor ative sua conta indo para a <a href=\"./activation.php\">página de ativação</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_dashboard'), 'Painel');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_prof_chnnl'), 'Gerenciar Perfil &amp; Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_friends'), 'Gerenciar Amigos &amp; Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_prof_channel'), 'Perfil/Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_message_box'), 'Caixa de Mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_new_messages'), 'Novas mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_goto_inbox'), 'Ir para Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_goto_sentbox'), 'Ir para Caixa de Envios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_compose_new'), 'Compor novas mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_total_subs_users'), 'Total de usuários inscritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_you_have'), 'Você possui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fav_videos'), 'Vídeos Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_your_vids_watched'), 'Seus vídeos assistidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_times'), 'Tempos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_you_have_watched'), 'Você assistiu');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_channel_profiles'), 'Canal e Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_channel_views'), 'Visualizações do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_channel_comm'), 'Comentários do Canal ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_prof'), 'Gerenciar Perfil / Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_you_created'), 'Você criou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_you_joined'), 'Você se juntou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_create_group'), 'Criar Novo Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_my_account'), 'Gerenciar minha conta ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_my_videos'), 'Gerenciar Meus Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_my_channel'), 'Gerenciar Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_sent_box'), 'Meus itens enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_channel'), 'Gerenciar Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_my_contacts'), 'Gerenciar Meus Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_contacts'), 'Gerenciar Contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_manage_favourites'), 'Gerenciar Vídeos Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_mem_login'), 'Acesso de membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_already_have'), 'Por favor, entre aqui se você já tem uma conta de');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_forgot_username'), 'Esqueceu o seu nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_forgot_password'), 'Esqueci minha senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_create_your'), 'Crie o seu ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'all_fields_req'), 'Todos os campos são obrigatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_valid_email_addr'), 'Endereço de e-mail válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_allowed_format'), 'Letras A-Z ou a-z, Números 0-9 e Sub-sublinhados _');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_confirm_pass'), 'Confirmar Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_reg_msg_0'), 'Registrar como ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_reg_msg_1'), 'membro, sua versão gratuita e fácil apenas preencha o formulário abaixo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_date_of_birth'), 'Data de nascimento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_enter_text_as_img'), 'Digite o texto como visto na imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_refresh_img'), 'Atualizar imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_i_agree_to_the'), 'Concordo com os  <a href=\"%s\" target=\"_blank\">Termos de Serviço</a> e com a <a href=\"%s\" target=\"_blank\" >Política de Privacidade</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_thanks_for_reg'), 'Obrigado por registrar-se no ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_email_has_sent'), 'Um e-mail foi enviado para sua caixa de entrada contendo sua conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_and_activation'), '&amp; Ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_details_you_now'), 'Detalhes. Agora você pode fazer as seguintes coisas em nossa rede');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_upload_share_vds'), 'Enviar, Compartilhar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_make_friends'), 'Fazer Amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_send_messages'), 'Enviar mensagens');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_grow_your_network'), 'Aumente suas redes convidando mais amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_rate_comment'), 'Avaliar e comentar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_make_customize'), 'Faça e Personalize seu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_to_upload_vid'), 'Para Fazer Upload de Vídeo, É necessário ativar a sua conta primeiro, Os detalhes de ativação foram enviados para sua conta de e-mail, pode levar algumas vezes para chegar à sua caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_click_to_login'), 'Clique aqui para acessar sua conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_view_my_channel'), 'Ver Meu Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_change_pass'), 'Alterar senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_email_settings'), 'Configurações de email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_profile_settings'), 'Opções do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_usr_prof_chnl_edit'), 'Editar Perfil de Usuário &amp; Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_personal_info'), 'Informações Pessoais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fname'), 'Nome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_lname'), 'Sobrenome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_gender'), 'Sexo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_relat_status'), 'Estado de relacionamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_display_age'), 'Mostrar idade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_about_me'), 'Sobre mim');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_website_url'), 'URL do website');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_eg_website'), 'e.g www.seusite.com');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_prof_info'), 'Informações Profissionais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_education'), 'Educação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_school_colleges'), 'Escolas / Faculdades');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_occupations'), 'Ocupação(ões)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_companies'), 'Empresas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_sperate_by_commas'), 'separados por vírgulas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_interests_hobbies'), 'Interesses e Hobbies');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fav_movs_shows'), 'Filmes favoritos &amp; Séries');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fav_music'), 'Músicas Favoritas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_fav_books'), 'Livros Favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_user_avatar'), 'Avatar de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_upload_avatar'), 'Enviar avatar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_channel_info'), 'Informações do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_channel_title'), 'Título do Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_channel_description'), 'Descrição do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_channel_permission'), 'Permissões do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_allow_comments_msg'), 'Usuários podem comentar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_dallow_comments_msg'), 'Usuários não podem comentar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_allow_rating'), 'Permitir avaliação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_dallow_rating'), 'Não permitir avaliação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_allow_rating_msg1'), 'Usuários podem avaliar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_dallow_rating_msg1'), 'Usuários não podem avaliar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_channel_feature_vid'), 'Vídeo em destaque do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_select_vid_for_fr'), 'Selecione o Vídeo para Definir como Destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_chane_channel_bg'), 'Alterar fundo do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_remove_bg'), 'Remover fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_currently_you_d_have_pic'), 'Atualmente você não possui uma Imagem de Fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_change_email'), 'Alterar Email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_email_address'), 'Endereço de e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_new_email'), 'Novo e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_notify_me'), 'Notificar-me quando o usuário me enviar uma mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_old_pass'), 'Senha Antiga');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_new_pass'), 'Nova senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_c_new_pass'), 'Confirmar Nova Senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_doesnt_exist'), 'O usuário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_do_not_have_contact'), 'O usuário não possui nenhum contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_no_fav_video_exist'), 'Usuário não tem nenhum vídeo favorito selecionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_have_no_vide'), 'O usuário não possui vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_s_channel'), 'Canal de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_last_login'), 'Última Conexão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_add_contact'), 'Adicionar contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_dob'), 'DoB');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_movies_shows'), 'Filmes &amp; Séries');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_add_comment'), 'Adicionar Comentário ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_no_fr_video'), 'O usuário não selecionou nenhum vídeo para definir como destaque');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_view_all_video_of'), 'Ver Todos os Vídeos de ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'menu_home'), 'Início');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'menu_inbox'), 'Caixa de entrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat_err2'), 'Você não pode selecionar mais de %d categorias');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_subscribe_message'), 'Olá %subscriber%\nVocê se inscreveu no %user% e portanto esta mensagem é enviada para você automaticamente, porque %user% enviou um novo vídeo\n\n%website_title%');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_subscribe_subject'), '%user% enviou um novo vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_already_logged'), 'Você já está logado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_not_logged_in'), 'Você não está logado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'invalid_user'), 'Usuário Inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_cat_err3'), 'Por favor, selecione pelo menos uma categoria');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'embed_code_invalid_err'), 'Código de incorporação de vídeo inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'invalid_duration'), 'Duração inválida');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_thumb_changed'), 'Miniatura padrão do vídeo foi alterada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_thumb_change_err'), 'Miniatura de vídeo não encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_vid_thumbs_msg'), 'Todas as miniaturas de vídeo foram carregadas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_thumb_delete_msg'), 'A miniatura do vídeo foi excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_thumb_delete_err'), 'Não foi possível excluir a miniatura do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_comment_del_perm'), 'Você não tem permissão para excluir este comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_text_context'), 'Meu contexto de teste');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_title'), 'Título de Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_dob'), 'Mostrar Data de Nascimento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_tags'), 'Tags do Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_desc'), 'Descrição do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'online_status'), 'Situação do Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_profile'), 'Mostrar Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'allow_ratings'), 'Permitir avaliações de perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'postal_code'), 'Código postal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'temp_file_load_err'), 'Não foi possível carregar o arquivo de tempalte \'%s\' no diretório \'%s\'');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_no_subscribers'), '%s não tem inscritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_subscriptions'), 'Inscrições de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_no_subscriptions'), '%s não possui inscrições');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'usr_avatar_bg_update'), 'O avatar do usuário e o plano de fundo foram atualizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_email_confirm_email_err'), 'Confirmar e-mail incorreto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_change_msg'), 'E-mail foi alterado com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_edit_video'), 'Você não pode editar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'confirm_del_video'), 'Tem certeza de que deseja excluir este vídeo?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remove_fav_video_confirm'), 'Tem certeza de que deseja remover este vídeo dos seus favoritos?');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'ban_users'), 'Banir Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'spe_users_by_comma'), 'separar nomes de usuários por vírgula');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_ban_msg'), 'Lista de bloqueio de usuários atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_user_ban_msg'), 'Nenhum usuário foi banido da sua conta!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thnx_sharing_msg'), 'Obrigado por compartilhar %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_own_commen_rate'), 'Você não pode avaliar seu próprio comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_comment_exists'), 'O comentário não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'thanks_rating_comment'), 'Obrigado por avaliar o comentário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_login_create_playlist'), 'Por favor, faça login para criar listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_have_no_playlists'), 'O usuário não possui listas de reprodução');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'this_thing_added_playlist'), 'Este %s foi adicionado à lista de reprodução');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'group_join_login_err'), 'Por favor, faça o login para participar deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_playlist'), 'Gerenciar listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_notifications'), 'Minhas notificações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'users_contacts'), 'Contatos de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'type_flags_removed'), '%s sinalizações foram removidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'terms_of_serivce'), 'Termos de Serviço');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'arslan_hassan'), 'Arslan Hassan');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_not_allowed_add_grp_vids'), 'Você não é membro deste grupo, então não pode adicionar vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'sel_vids_updated'), 'Os vídeos selecionados foram atualizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'unable_find_download_file'), 'Não foi possível encontrar o arquivo de download');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_edit_group'), 'Você não pode editar esse grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_invite_mems'), 'Você não pode convidar membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_moderate_group'), 'Você não pode moderar este grupo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_details_updated'), 'Os detalhes do grupo foram atualizados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_del_topic'), 'Você não pode apagar este tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_del_user_topics'), 'Você não pode excluir tópicos de usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'topics_deleted'), 'Os tópicos foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_delete_grp_topics'), 'Você não pode excluir tópicos do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_not_allowed_post_topics'), 'Você não tem permissão para postar tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_add_this_vdo'), 'Você não pode adicionar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_added'), 'O vídeo foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_del_this_vdo'), 'Você não pode remover este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_removed'), 'O vídeo foi removido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_not_grp_mem'), 'O usuário não é membro do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_already_group_mem'), 'O usuário já ingressou neste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'invitations_sent'), 'Os convites foram enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_not_grp_mem'), 'Você não é membro deste grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_delete_this_grp'), 'Você não pode excluir este grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_deleted'), 'O grupo foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_del_grp_mems'), 'Você não pode excluir membros do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'mems_deleted'), 'Os membros foram excluídos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_del_grp_vdos'), 'Você não pode excluir vídeos de grupo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'phrase_code_empty'), 'O código da frase estava vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'phrase_text_empty'), 'O texto da frase estava vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'language_does_not_exist'), 'O idioma não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'name_has_been_added'), '%s foi adicionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'name_already_exists'), '\'%s\' já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_doesnt_exist'), 'O idioma não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_file_was_selected'), 'Nenhum arquivo foi selecionado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'err_reading_file_content'), 'Erro ao ler conteúdo do arquivo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cant_find_lang_name'), 'Nome do idioma não encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cant_find_lang_code'), 'Não conseguimos encontrar o código do idioma');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_phrases_found'), 'Nenhuma frase foi encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'language_already_exists'), 'O idioma já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_added'), 'Idioma adicionado com sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'error_while_upload_file'), 'Ocorreu um erro ao carregar o arquivo do idioma');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'default_lang_del_error'), 'Este é o idioma padrão, selecione outro idioma como «padrão» e então exclua este pacote');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_deleted'), 'O pacote de idioma foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_name_empty'), 'O nome do idioma está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_code_empty'), 'O código do idioma estava vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_regex_empty'), 'Expressão regular do idioma estava vazia');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_code_already_exist'), 'O código de idioma já existe');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'perm_code_empty'), 'O código de permissão está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'perm_name_empty'), 'O nome da permissão está vazio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'perm_already_exist'), 'A permissão já existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'perm_type_not_valid'), 'Tipo de permissão inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'perm_added'), 'Nova permissão foi adicionada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'perm_deleted'), 'A permissão foi excluída');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'perm_doesnt_exist'), 'A permissão não existe');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'acitvation_html_message'), 'Digite seu nome de usuário e código de ativação para ativar sua conta. Não esqueça de checar a sua caixa de entrada para encontrar o código de ativação, caso não tenha recebido um, por favor solicite-o preenchendo o formulário a seguir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'acitvation_html_message2'), 'Por favor, digite seu endereço de e-mail para solicitar o código de ativação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'admin_panel'), 'Painel de Administração');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'moderate_videos'), 'Moderar Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'moderate_users'), 'Moderar Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'revert_back_to_admin'), 'Reverter para o administrador');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'more_options'), 'Mais Opções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'downloading_string'), 'Baixando %s...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'download_redirect_msg'), '<a href=\"%s\">clique aqui se você não for redirecionado automaticamente</a> - <a href=\"%s\"> Clique Aqui para voltar à Página do Vídeo</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'account_details'), 'Detalhes de conta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_details'), 'Detalhes do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_profile'), 'Atualizar o perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_select_img_file'), 'Por favor, selecione arquivo de imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'or'), 'ou');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pelase_enter_image_url'), 'Digite a URL da imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_bg'), 'Fundo do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_bg_img'), 'Imagem de Fundo do Canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_bg_color'), 'Digite a cor de fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'bg_repeat_type'), 'Tipo de repetição de fundo (se estiver usando a imagem como plano de fundo)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'fix_bg'), 'Corrigir fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'delete_this_img'), 'Excluir esta imagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'current_email'), 'E-mail atual');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'confirm_new_email'), 'Confirme o novo email');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_subs_found'), 'Nenhum inscrição encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_info_all_fields_req'), 'Informações de Vídeo - Todos os campos são obrigatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_group'), 'Atualizar Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'default'), 'Padrão');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_info_all_fields_req'), 'Informações do Grupo - Todos os Campos são Obrigatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date_recorded_location'), 'Data de gravação &amp; localização');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_video'), 'Atualizar vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'click_here_to_recover_user'), 'Clique aqui para recuperar o nome de usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'click_here_reset_pass'), 'Clique aqui para redefinir a senha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remember_me'), 'Lembrar de mim');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'howdy_user'), 'Olá %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'notifications'), 'Notificações');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlists'), 'Listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friend_requests'), 'Pedidos de Amizade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'after_meny_guest_msg'), 'Bem-vindo, convidado! Por favor <a href=\"%s\">faça o login</a> ou <a href=\"%s\">registre-se</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'being_watched'), 'Sendo assistido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'change_style_of_listing'), 'Alterar estilo da listagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'website_members'), '%s Membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'guest_homeright_msg'), 'Assistir, enviar, compartilhar e muito mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'reg_for_free'), 'Registre-se gratuitamente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'rand_vids'), 'Vídeos Aleatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 't_10_users'), 'Top 10 Usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pending'), 'Pendente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'confirm'), 'Confirmar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_contacts'), 'Sem contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_hv_any_grp'), 'Você não tem nenhum grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_joined_any_grp'), 'Você não entrou em nenhum grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'leave_groups'), 'Sair de grupos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_grp_mems'), 'Gerenciar membros do grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pending_mems'), 'Membros pendentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'active_mems'), 'Membros ativos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'disapprove'), 'Reprovar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_grp_vids'), 'Gerenciar vídeos em grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pending_vids'), 'Vídeos pendentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_pending_vids'), 'Nenhum vídeo pendente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_active_videos'), 'Não há vídeos ativos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'active_videos'), 'Vídeos ativos');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'search_for_s'), 'Pesquisar por %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_success_usr_ok'), 'Apenas mais um passo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_success_usr_ok_description'), 'Você é apenas um passo para trás de se tornar um meme oficial do nosso site. Por favor, verifique seu e-mail, enviamos um e-mail de confirmação que contém um link de confirmação do nosso site. Por favor, clique nele para completar o seu registro.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_success_usr_emailverify'), '<h2 style=\"font-family:Arial,Verdana,sans-serif; margin:5px 5px 8px;\">Bem-vindo à nossa comunidade</h2>\n    \t<p style=\"margin:0px 5px; line-height:18px; font-size:11px;\">Seu e-mail foi confirmado, Por favor <strong><a href=\"%s\">clique aqui para fazer login</a></strong> e continuar como nosso membro registrado.</p>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'if_you_already_hv_account'), 'se você já tem uma conta, faça login aqui ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signup_message_under_login'), ' <p>Nosso site é o lar do vídeo online:</p>\n          \n            <ul><li><strong>Assista</strong> milhares de vídeos</li><li><strong>Compartilhe seus favoritos</strong> com amigos e familiares</li>\n            <li><strong>Conecte-se com outros usuários</strong> que compartilham seus interesses</li><li><strong>Envie seus vídeos</strong> para uma audiência mundial\n\n</li></ul>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'new_mems_signup_here'), 'Novos membros se registram aqui');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'register_as_our_website_member'), 'Registre-se como membro, é gratuito e fácil apenas ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_complete_msg'), '<h2>O Upload de vídeo foi concluído</h2>\n<span class=\"header1\">Obrigado! Seu upload está completo.</span><br>\n<span class=\"tips\">Este vídeo estará disponível em <a href=\"%s\"><strong>Meus Vídeos</strong></a> depois de ter terminado de processar.</span>  \n<div class=\"upload_link_button\" align=\"center\">\n    </h2>    <ul>\n        <li><a href=\"%s\" >Enviar Outro Vídeo</a></li>\n        <li><a href=\"%s\" >Vá para Meus Vídeos</a></li>\n    </ul>\n<div class=\'clearfix\'></div>\n</div>\n');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_right_guide'), ' <div>\n            <div>\n              <p>\n                <strong>\n                <strong>Importante:</strong>\n                Não envie nenhum programa de TV, vídeos de musicas, shows de música, ou comerciais sem permissão, a menos que consistam inteiramente de conteúdo que você mesmo criou.</strong></p>\n                <p>As paginas de \n                <a href=\"#\">Direitos Autorais</a> e as \n                <a href=\"#\">Diretrizes da Comunidade</a> podem ajudá-lo a determinar se seu vídeo viola os direitos autorais de outra pessoa.</p>\n                <p>clicando em \"Enviar Vídeo\", você está representando que este vídeo não viola os \n                <a id=\"terms-of-use-link\" href=\"#\">Termos de Uso</a> \n                do nosso site e que você possui todos os direitos autorais sobre este vídeo ou tem autorização para envia-lo.</p>\n            </div>\n        </div>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_this_user'), 'Denunciar este Usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_favs'), 'Meu Favorito!');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_this'), 'Denunciar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'share_this'), 'Compatilhe isto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_to_playlist'), 'Adicionar à lista de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_profile'), 'Ver Perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subscribe'), 'Inscrever-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'uploaded_by_s'), 'Enviado por %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'more'), 'Mais');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'link_this_video'), 'Link para o vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'click_to_download_video'), 'Clique aqui para baixar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'name'), 'Nome');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'email_wont_display'), 'E-mail (não será exibido)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_login_to_comment'), 'Por favor, inicie a sessão para comentar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'marked_as_spam_comment_by_user'), 'Marcado como spam, comentado por <em>%s</em>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'spam'), 'Spam');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_commented_time'), '<a href=\"%s\">%s</a> comentou %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_comments'), 'Ninguém comentou sobre este %s ainda');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_video'), 'Assistir ao vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'topic_icon'), 'Ícone do tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'group_options'), 'Opção de grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'info'), 'Informação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'basic_info'), 'Informações básicas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'group_owner'), 'Dono do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_mems'), 'Total de membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_topics'), 'Total de tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'grp_url'), 'URL do Grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'more_details'), 'Mais detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_all_mems'), 'Ver todos os membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_all_vids'), 'Ver Todos os Vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'topic_title'), 'Título do Tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'last_reply'), 'Última resposta');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'topic_by_user'), '<a href=\"%s\">%s</a></span> por <a href=\"%s\">%s</a>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_topics'), 'Não há tópicos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'last_post_time_by_user'), '%s<br />\npor <a href=\"%s\">%s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'profile_views'), 'Visualizações do perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'last_logged_in'), 'Último acesso em');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'last_active'), 'Última vez ativo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_logins'), 'Total de logins');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_videos_watched'), 'Total de vídeos assistidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_group'), 'Ver grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_hv_any_pm'), 'Não há mensagens para exibir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'date_sent'), 'Data de envio');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'show_hide'), 'Mostrar - Ocultar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'quicklists'), 'Listas rápidas');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'are_you_sure_rm_grp'), 'Tem certeza que deseja remover este grupo?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'are_you_sure_del_grp'), 'Tem certeza que deseja excluir este grupo?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'change_avatar'), 'Alterar Avatar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'change_bg'), 'Alterar Fundo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'uploaded_videos'), 'Vídeos enviados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_playlists'), 'Listas de reprodução de vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_contact_list'), 'Adicionar lista de contatos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'topic_post'), 'Postagem do tópico');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'invite'), 'Convidar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'time_ago'), '%s %s atrás');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'from_now'), '%s %s a partir de agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_has_been_activated'), 'O idioma foi ativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_has_been_deactivated'), 'O idioma foi desativado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'lang_default_no_actions'), 'Idioma é padrão então você não pode executar ações nele');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comm_disabled_for_vid'), 'Comentários desativados para este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'coments_disabled_profile'), 'Comentários desativados para este perfil');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'file_size_exceeds'), 'Tamanho do arquivo excede \'%s kbs\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vid_rate_disabled'), 'A avaliação do vídeo está desativada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'chane_lang'), '- Alterar Idioma -');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'recent'), 'Recente');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'viewed'), 'Visualizado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'top_rated'), 'Melhor avaliado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'commented'), 'Comentado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'searching_keyword_in_obj'), 'Pesquisando \'%s\' em %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_results_found'), 'Nenhum resultado encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_val_bw_min_max'), 'Por favor, digite um valor para \'%s\' entre \'%s\' e \'%s\'');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_new_subs_video'), 'Não foram encontrados novos vídeos nas assinaturas');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pending_requests'), 'Solicitações pendentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'friend_add_himself_error'), 'Você não pode se adicionar como amigo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'contact_us_msg'), 'Os seus comentários são importantes para nós e vamos avaliar eles o mais rapidamente possível. A informação solicitada neste formulário é voluntária. As informações estão a ser recolhidas para fornecer informações adicionais solicitadas por si e ajuda-nos a melhorar os nossos serviços.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'failed'), 'Falha');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'required_fields'), 'Campos obrigatórios');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'more_fields'), 'Mais campos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remote_upload_file'), 'enviando arquivo <span id=\\\"remoteFileName\\\"></span>, aguarde...');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_remote_file_url'), 'Digite a URL do arquivo remoto');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_videos_can_be'), '<span style=\\\"font-weight: bold; font-size: 13px;\\\">Os vídeos podem ser</span>     <ul>         <li>de Alta Definição</li>         <li>Até %s de tamanho</li>         <li>Até %s de duração</li>         <li>Uma grande variedade de formatos</li>     </ul>');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_non_readable'), 'A foto não está legível.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'wrong_mime_type'), 'Tipo MIME errado fornecido.');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_tags'), 'Tags de Fotos');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_upload_opt'), 'Nenhuma opção de upload permitida por {title}, por favor, contate o administrador do site.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photos'), 'Fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'cat_all'), 'Todos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_desktop_msg'), 'Envie vídeos diretamente da sua área de trabalho e compartilhe-os online com a nossa comunidade ');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_remote_video_msg'), 'Enviar vídeos de outros sites ou servidores, simplesmente insira sua URL e clique em Enviar ou você pode inserir a URL do Youtube e clique em Resgatar do YouTube para enviar o vídeo diretamente do youtube sem inserir seus detalhes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'embed_video_msg'), 'Incorporar vídeos de diferentes sites usando seus \"codigo e imcorporação de vídeo\", basta inserir o código incorporado, insira a duração do vídeo e selecione uma miniatura, preencha os detalhes necessários e clique em enviar.');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'most_downloaded'), 'Mais baixados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_videos'), 'Total de vídeos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_featured'), 'Coleção destacada.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_unfeatured'), 'Coleção removida dos destaque.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_right_guide_photo'), '<strong>Importante: Não envie nenhuma foto que possa ser interpretada como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que estas fotos não violam os <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Termos de Uso do nosso site</span></a> e que você possui todos os direitos autorais destas fotos ou tem autorização para fazer o seu envio.</p>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_right_guide_vid'), '<strong>Importante: Não carregue nenhum vídeo que possa ser interpretado como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que estes vídeos não violam os <a id=\"terms-of-use-link\" href=\"%s\"><span style=\"color:orange;\">Termos de Uso do nosso site</span></a> e que você possui todos os direitos autorais destes vídeos ou tem autorização para fazer o seu envio.</p>');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collect_items_deleted'), 'Itens da coleção excluídos com sucesso.');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_title_err'), 'Por favor, digite um título válido para a foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'rand_photos'), 'Fotos aleatórias');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'watch_video_page'), 'Assistir na página do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'watch_on_photo_page'), 'Assistir na página da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'found_no_videos'), 'Nenhum vídeo encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'found_no_photos'), 'Nenhuma foto encontrada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collections'), 'Coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'related_videos'), 'Vídeos Relacionados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'this_video_found_in_no_collection'), 'Este vídeo foi encontrado nas seguintes coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'more_from'), 'Mais de %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'this_collection'), 'Coleção : %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_broadcast_unlisted'), 'Não listado (qualquer um com o link e/ou senha pode visualizar)');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'video_link'), 'Link do vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channel_settings'), 'Configurações do canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'channel_account_settings'), 'Configurações do canal e conta');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_doesnt_any_collection'), 'Usuário não tem nenhuma coleção.');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_collections'), 'Total de coleções');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_photos'), 'Total de fotos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comments_made'), 'Comentários feitos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'block_users'), 'Bloquear usuários');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'tp_del_confirm'), 'Tem certeza que deseja excluir esse tópico?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_need_owners_approval_to_view_group'), 'Você precisa de aprovação de proprietários para visualizar este grupo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_confimation_ode'), 'Por favor, digite o código de verificação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_brd_confidential'), 'Confidencial (Apenas para usuários especificados)');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_provide_valid_userid'), 'informe um ID de usuário válido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_joined_us'), '%s juntou-se a %s , disse olá para %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_uploaded_new_video'), '%s enviou um novo vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_created_new_group'), '%s criou um novo grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'total_members'), 'Total de membros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'watch_video'), 'Assista ao vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_photo'), 'Ver foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_joined_group'), '%s juntou-se a um novo grupo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_is_now_friend_with_other'), '%s e %s agora são amigos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_created_new_collection'), '%s criou uma nova coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_collection'), 'Ver a coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_has_favorited_video'), '%s adicionou um vídeo aos favoritos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'activity'), 'Atividade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_activity'), '%s não possui atividades recentes');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'feed_has_been_deleted'), 'Feed de atividades foi excluído');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_del_this_feed'), 'Você não pode excluir este feed');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_cant_sub_yourself'), 'Você não pode se inscrever em seu proprio canal');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'manage_my_album'), 'Gerenciar meu álbum');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_permission_to_update_this_video'), 'Você não tem permissão para atualizar este vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'group_is_public'), 'O grupo é público');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_thumb'), 'Miniatura da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'collection_is_private'), 'A Coleção é privada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'edit_type_collection'), 'Editando %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comm_disabled_for_collection'), 'Comentários desativados nesta coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'share_this_type'), 'Compartilhar este %s');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'seperate_usernames_with_comma'), 'Separe nomes de usuário com vírgula');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'view_all'), 'Visualizar tudo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'album_privacy_updated'), 'A privacidade do álbum foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_any_videos'), 'Você não tem nenhum vídeo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_blocked_use'), 'A lista de usuários bloqueada foi atualizada');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_dont_have_fav_collections'), 'Você não tem nenhuma coleção favorita');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'remote_upload_example'), 'ex. http://sitedeenvio.com/exemplo.flv http://www.youtube.com/watch?v=QfRHfquzM0');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'update_blocked_user_list'), 'Atualizar lista de usuários bloqueados');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'group_is_private'), 'O grupo é privado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_user_associated_with_email'), 'Nenhum usuário está associado a este endereço de e-mail');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'pass_changed_success'), '<div class=\"simple_container\">\n    \t<h2 style=\"margin: 5px 5px 8px; font-family: Arial,Verdana,sans-serif;\">A senha foi alterada, por favor, verifique seu e-mail</h2>     \t<p style=\"margin: 0px 5px; line-height: 18px; font-size: 11px;\">Sua senha foi alterada com sucesso, por favor, verifique sua caixa de entrada para converir a senha recém-gerada, assim que você acessar a sua conta, altere a sua senha clicando em Mudar a senha.</p>\n </div>');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'add_as_friend'), 'Adicionar como Amigo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'block_user'), 'Bloquear usuário');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'send_message'), 'Enviar mensagem');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_item_was_selected_to_delete'), 'Nenhum item foi selecionado para excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'playlist_items_have_been_removed'), 'Os itens da lista de reprodução foram removidos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'you_not_grp_mem_or_approved'), 'Você não entrou ou não é um membro aprovado deste grupo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'download'), 'Baixar');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'flag_video'), 'Sinalizar este vídeo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_beats_guide'), '<strong>Importante: Não carregue nenhum áudio que possa ser interpretado como Obscenidade, material protegido por direitos autorais, assédio ou spam.</strong>\n<p>Continuando \"Seu Envio\", você está representando que esses áudios não violam os Termos de Uso de Nosso Site e que você possui todos os direitos autorais desses áudios ou tem autorização para fazer o seu envio.</p>');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'contact'), 'Contato');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_featured_videos_found'), 'Nenhum vídeo em destaque encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_recent_videos_found'), 'Nenhum vídeo recente encontrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_collection_found_alert'), 'Nenhuma coleção encontrada! Você deve criar uma coleção antes de enviar qualquer foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'select_collection_upload'), 'Selecionar coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_collection_upload'), 'Nenhuma coleção encontrada');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'upload_in_progress'), 'Envio em andamento');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'complete_of_video'), 'Conclusão do Vídeo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'agree'), 'Eu concordo com os');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'terms'), 'Termos de Serviço');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'and'), 'e');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'policy'), 'Política de Privacidade');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'watch'), 'Assistir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'edit_video'), 'Editar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'del_video'), 'Excluir');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'successful'), 'Sucesso');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'processing'), 'Processando');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'last_one'), 'Ultimo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'subscribe_btn'), 'Inscrever-se');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'report_usr'), 'Denunciar');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'un_reg_user'), 'Usuário não registrado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'my_playlists'), 'Minhas listas de reprodução');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'play'), 'Reproduzir agora');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'no_vid_in_playlist'), 'Nenhum vídeo encontrado nesta lista de reprodução!');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'anonymous'), 'Anônimo');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'please_enter_collection_name'), 'Por favor, insira o nome da coleção');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'select_collection'), 'Selecione da coleção');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'edited_by'), 'editado por');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'embed_type'), 'Tipo de Incorporação');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'confirm_del_photo'), 'Você tem certeza que deseja excluir esta foto?');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'vdo_inactive'), 'O vídeo está inativo');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_tags_error'), 'Por favor, especifique tags para a Foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'signups'), 'Cadastros');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'active_users'), 'Usuários Ativos');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'uploaded'), 'Enviado');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'user_name_invalid_len'), 'Comprimento do usuário é inválido');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'username_spaces'), 'O nome de usuário não pode conter espaços');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_caption_err'), 'Digite a descrição da foto');
INSERT INTO `{tbl_prefix}languages_translations` (`language_id`, `id_language_key`, `translation`)
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'photo_tags_err'), 'Por favor, digite Tags Para a Foto');
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
VALUES (@language_id, (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE language_key = 'comments_disabled_for_photo'), 'Comentários desativados para esta foto');
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
