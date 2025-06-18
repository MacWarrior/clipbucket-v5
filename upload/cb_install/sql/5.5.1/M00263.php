<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00263 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('warning_php_version', [
            'pt-BR' => 'Caro administrador,<br/>Parece que você está usando uma versão antiga do PHP (<b>%s</b>). Esta versão não será mais suportada nas próximas versões do <b>%s</b>.<br/>Por favor, ATUALIZE sua versão do PHP PARA %s OU acima.<br/><br/>Obrigado POR USAR ClipBucketV5 !'
        ]);
        self::generateTranslation('email_template_management', [
            'pt-BR' => 'Gerenciamento de modelos de e-mail'
        ]);
        self::generateTranslation('email_template_management_desc', [
            'pt-BR' => 'Pode gerenciar modelos de e-mail'
        ]);
        self::generateTranslation('empty_email_content', [
            'pt-BR' => 'Pode gerenciar modelos de e-mail'
        ]);
        self::generateTranslation('rendered', [
            'pt-BR' => 'Renderizado'
        ]);
        self::generateTranslation('code_cannot_be_empty', [
            'pt-BR' => 'O código não pode estar vazio'
        ]);
        self::generateTranslation('back_to_list', [
            'pt-BR' => 'Voltar para a lista'
        ]);
        self::generateTranslation('code_already_exist', [
            'pt-BR' => 'Este código já existe. Por favor, escolha outro'
        ]);
        self::generateTranslation('template_set_default', [
            'pt-BR' => 'O modelo %s foi definido como padrão'
        ]);
        self::generateTranslation('confirm_default_template', [
            'pt-BR' => 'Deseja aplicar este novo modelo de e-mail padrão a todos os e-mails existentes?'
        ]);
        self::generateTranslation('email_variable_content', [
            'pt-BR' => 'Esta variável será substituída pelo conteúdo do e-mail'
        ]);
        self::generateTranslation('success', [
            'pt-BR' => 'Operação concluída com sucesso'
        ]);
        self::generateTranslation('sender', [
            'pt-BR' => 'Remetente'
        ]);
        self::generateTranslation('email_sender', [
            'pt-BR' => 'E-mail do remetente'
        ]);
        self::generateTranslation('recipient', [
            'pt-BR' => 'Destinatário'
        ]);
        self::generateTranslation('email_recipient', [
            'pt-BR' => 'E-mail do destinatário'
        ]);
        self::generateTranslation('select_an_email', [
            'pt-BR' => 'Escolha um e-mail'
        ]);
        self::generateTranslation('invalid_email_recipient', [
            'pt-BR' => 'Forneça um endereço de e-mail de destinatário válido'
        ]);
        self::generateTranslation('invalid_email_sender', [
            'pt-BR' => 'Forneça um endereço de e-mail de remetente válido'
        ]);
        self::generateTranslation('missing_recipient', [
            'pt-BR' => 'Destinatário ausente'
        ]);
        self::generateTranslation('unknown_email', [
            'pt-BR' => 'E-mail desconhecido'
        ]);
        self::generateTranslation('template_dont_exist', [
            'pt-BR' => 'O modelo não existe'
        ]);
        self::generateTranslation('email_sender_address', [
            'pt-BR' => 'Endereço do remetente do e-mail'
        ]);
        self::generateTranslation('email_sender_name', [
            'pt-BR' => 'Nome do remetente do e-mail'
        ]);
        self::generateTranslation('error_mail', [
            'pt-BR' => 'Ocorreu um erro durante o envio do e-mail: %s'
        ]);
        self::generateTranslation('email_variable_website_title', [
            'pt-BR' => 'O título do site'
        ]);
        self::generateTranslation('email_variable_user_username', [
            'pt-BR' => 'Nome de usuário do destinatário'
        ]);
        self::generateTranslation('email_variable_user_avatar', [
            'pt-BR' => 'URL do avatar do destinatário'
        ]);
        self::generateTranslation('email_variable_date_year', [
            'pt-BR' => 'Ano atual'
        ]);
        self::generateTranslation('email_variable_baseurl', [
            'pt-BR' => 'URL do Website'
        ]);
        self::generateTranslation('email_variable_date_time', [
            'pt-BR' => 'Data e hora da criação do e-mail'
        ]);
        self::generateTranslation('email_variable_login_link', [
            'pt-BR' => 'Link para a página de login'
        ]);
        self::generateTranslation('email_variable_avcode', [
            'pt-BR' => 'Código de validação da conta'
        ]);
        self::generateTranslation('email_variable_video_link', [
            'pt-BR' => 'Link para o vídeo'
        ]);
        self::generateTranslation('email_variable_video_title', [
            'pt-BR' => 'Título do vídeo'
        ]);
        self::generateTranslation('email_variable_video_thumb', [
            'pt-BR' => 'URL da miniatura do vídeo'
        ]);
        self::generateTranslation('email_variable_video_description', [
            'pt-BR' => 'Descrição do vídeo'
        ]);
        self::generateTranslation('email_variable_sender_message', [
            'pt-BR' => 'Conteúdo da mensagem'
        ]);
        self::generateTranslation('email_variable_subject', [
            'pt-BR' => 'Assunto da mensagem'
        ]);
        self::generateTranslation('email_variable_profile_link', [
            'pt-BR' => 'Link para o perfil do usuário'
        ]);
        self::generateTranslation('email_variable_request_link', [
            'pt-BR' => 'Link para solicitação de amizade'
        ]);
        self::generateTranslation('email_variable_photo_link', [
            'pt-BR' => 'Link para foto'
        ]);
        self::generateTranslation('email_variable_photo_thumb', [
            'pt-BR' => 'URL para a miniatura da foto'
        ]);
        self::generateTranslation('email_variable_photo_description', [
            'pt-BR' => 'Descrição da foto'
        ]);
        self::generateTranslation('email_variable_photo_title', [
            'pt-BR' => 'Título da foto'
        ]);
        self::generateTranslation('email_variable_collection_link', [
            'pt-BR' => 'Link para a coleção'
        ]);
        self::generateTranslation('email_variable_collection_thumb', [
            'pt-BR' => 'URL para a miniatura da coleção'
        ]);
        self::generateTranslation('email_variable_collection_description', [
            'pt-BR' => 'Descrição da coleção'
        ]);
        self::generateTranslation('email_variable_collection_title', [
            'pt-BR' => 'Título da coleção'
        ]);
        self::generateTranslation('email_variable_total_items', [
            'pt-BR' => 'Número de itens dentro da coleção'
        ]);
        self::generateTranslation('email_variable_collection_type', [
            'pt-BR' => 'Tipo de conteúdo da coleção (vídeo, foto, etc.)'
        ]);
        self::generateTranslation('email_variable_private_message_link', [
            'pt-BR' => 'Link para a caixa de entrada de mensagens'
        ]);
        self::generateTranslation('email_variable_password', [
            'pt-BR' => 'Senha gerada'
        ]);
        self::generateTranslation('email_variable_reset_password_link', [
            'pt-BR' => 'Link para redefinir a senha'
        ]);
        self::generateTranslation('email_variable_comment_link', [
            'pt-BR' => 'Link para comentar'
        ]);
        self::generateTranslation('email_variable_object', [
            'pt-BR' => 'Tipo de conteúdo do e-mail (vídeo, foto, etc.)'
        ]);
        self::generateTranslation('email_variable_sender_username', [
            'pt-BR' => 'Nome de usuário responsável pela mensagem'
        ]);
        self::generateTranslation('email_variable_sender_email', [
            'pt-BR' => 'E-mail do remetente'
        ]);
        self::generateTranslation('email_variable_user_email', [
            'pt-BR' => 'E-mail do destinatário'
        ]);
        self::generateTranslation('email_specific', [
            'pt-BR' => 'E-mail específico'
        ]);
        self::generateTranslation('title_email_variables', [
            'pt-BR' => 'Variáveis utilizáveis em e-mail'
        ]);
        self::generateTranslation('tips_email_variables', [
            'pt-BR' => 'As variáveis devem ser colocadas entre chaves duplas, por exemplo: {{website_title}}'
        ]);
        self::generateTranslation('email_variable_logo_url', [
            'pt-BR' => 'Link para o logotipo do site'
        ]);
        self::generateTranslation('email_variable_favicon_url', [
            'pt-BR' => 'Link para o favicon do site'
        ]);
        self::generateTranslation('cannot_remove_default_have_to_add_one', [
            'pt-BR' => 'Não é possível remover o modelo padrão, escolha outro'
        ]);
        self::generateTranslation('this_user_blocked_you', [
            'pt-BR' => 'Este usuário bloqueou você: %s'
        ]);
        self::generateTranslation('user_is_banned', [
            'pt-BR' => 'Este usuário está banido: %s'
        ]);
        self::generateTranslation('you_cant_share_to_yourself', [
            'pt-BR' => 'Você não pode compartilhar consigo mesmo'
        ]);
        self::generateTranslation('link_this_photo', [
            'pt-BR' => 'Vincular esta foto'
        ]);
        self::generateTranslation('link_this_collection', [
            'pt-BR' => 'Vincular esta coleção'
        ]);
        self::generateTranslation('share', [
            'pt-BR' => 'Compartilhar'
        ]);
        self::generateTranslation('enable_link_sharing', [
            'pt-BR' => 'Habilitar compartilhamento de link'
        ]);
        self::generateTranslation('enable_internal_sharing', [
            'pt-BR' => 'Habilitar compartilhamento interno'
        ]);
        self::generateTranslation('element', [
            'pt-BR' => 'elemento'
        ]);
        self::generateTranslation('motif', [
            'pt-BR' => 'Razão'
        ]);
        self::generateTranslation('reporter', [
            'pt-BR' => 'Denunciante'
        ]);
        self::generateTranslation('unflag', [
            'pt-BR' => 'Desmarcar'
        ]);
        self::generateTranslation('delete_element', [
            'pt-BR' => 'Excluir elemento'
        ]);
        self::generateTranslation('unflag_and_activate', [
            'pt-BR' => 'Desmarcar e ativar'
        ]);
        self::generateTranslation('video_flagged', [
            'pt-BR' => 'Vídeos sinalizados'
        ]);
        self::generateTranslation('user_flagged', [
            'pt-BR' => 'Usuários sinalizados'
        ]);
        self::generateTranslation('collection_flagged', [
            'pt-BR' => 'Coleções sinalizadas'
        ]);
        self::generateTranslation('playlist_flagged', [
            'pt-BR' => 'Listas de reprodução sinalizadas'
        ]);
        self::generateTranslation('photo_flagged', [
            'pt-BR' => 'Fotos sinalizadas'
        ]);
        self::generateTranslation('report_successful', [
            'pt-BR' => 'Denunciado com sucesso'
        ]);
        self::generateTranslation('unflag_successful', [
            'pt-BR' => 'Desmarcado com sucesso'
        ]);
        self::generateTranslation('element_deleted', [
            'pt-BR' => 'O elemento foi excluído'
        ]);
        self::generateTranslation('nb_flag', [
            'pt-BR' => 'Número de sinalizações'
        ]);
        self::generateTranslation('flagged', [
            'pt-BR' => 'Sinalizado'
        ]);
        self::generateTranslation('must_update_version', [
            'pt-BR' => 'Seu banco de dados precisa ser atualizado'
        ]);
        self::generateTranslation('missing_email_recipient', [
            'pt-BR' => 'E-mail do destinatário ausente'
        ]);
        self::generateTranslation('missing_category_report', [
            'pt-BR' => 'Selecione uma categoria de denuncia'
        ]);
    }
}
