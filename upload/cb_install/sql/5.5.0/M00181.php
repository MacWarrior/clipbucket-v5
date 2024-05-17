<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00181 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('admin_tool', [
            'pt-BR'=>'Ferramentas Administrativas'
        ]);
        self::generateTranslation('launch', [
            'pt-BR'=>'Iniciar'
        ]);
        self::generateTranslation('stop', [
            'pt-BR'=>'Parar'
        ]);
        self::generateTranslation('in_progress', [
            'pt-BR'=>'Em progresso'
        ]);
        self::generateTranslation('ready', [
            'pt-BR'=>'Pronto'
        ]);
        self::generateTranslation('stopping', [
            'pt-BR'=>'Parando'
        ]);
        self::generateTranslation('generate_missing_thumbs_label', [
            'pt-BR'=>'Gerar miniaturas faltantes'
        ]);
        self::generateTranslation('generate_missing_thumbs_description', [
            'pt-BR'=>'Gerar miniaturas para os vídeos sem uma miniatura'
        ]);
        self::generateTranslation('update_castable_status_label', [
            'pt-BR'=>'Atualizar status de vídeos transmissíveis'
        ]);
        self::generateTranslation('update_castable_status_description', [
            'pt-BR'=>'Atualize o status de todos os vídeos que podem ser transmitidos com base nos arquivos de vídeo'
        ]);
        self::generateTranslation('update_bits_color_label', [
            'pt-BR'=>'Atualizar status de codificação de cores dos vídeos'
        ]);
        self::generateTranslation('update_bits_color_description', [
            'pt-BR'=>'Atualize o status de codificação de cores de todos os vídeos, com base nos arquivos de vídeo'
        ]);
        self::generateTranslation('update_videos_duration_label', [
            'pt-BR'=>'Atualizar as durações dos vídeos'
        ]);
        self::generateTranslation('update_videos_duration_description', [
            'pt-BR'=>'Atualize todas as durações dos vídeos, com base nos arquivos de vídeo'
        ]);
        self::generateTranslation('need_db_upgrade', [
            'pt-BR'=>'Você tem <b>%s</b> arquivos para executar para poder atualizar seu banco de dados. Você pode usar este link a seguir: '
        ]);
        self::generateTranslation('db_up_to_date', [
            'pt-BR'=>'Seu banco de dados está atualizado'
        ]);
        self::generateTranslation('update_database_version_label', [
            'pt-BR'=>'Atualizar seu banco de dados para a versão atual'
        ]);
        self::generateTranslation('update_database_version_description', [
            'pt-BR'=>'Execute todos os arquivos SQL necessários para atualizar o banco de dados'
        ]);
        self::generateTranslation('no_version', [
            'pt-BR'=>'Seu ClipBucket usa o antigo sistema de atualização de banco de dados. Execute todos os arquivos de migração SQL para a versão 5.3.0 antes de continuar.'
        ]);
        self::generateTranslation('select_version', [
            'pt-BR'=>'Por favor, selecione sua versão atual e a revisão'
        ]);
        self::generateTranslation('version', [
            'pt-BR'=>'versão'
        ]);
        self::generateTranslation('revision', [
            'pt-BR'=>'revisão'
        ]);
        self::generateTranslation('system_info', [
            'pt-BR'=>'Informações do Sistema'
        ]);
        self::generateTranslation('hosting', [
            'pt-BR'=>'Hospedagem'
        ]);
        self::generateTranslation('info_ffmpeg', [
            'pt-BR'=>'é usado para converter vídeos de diferentes versões para FLV, MP4 e muitos outros formatos.'
        ]);
        self::generateTranslation('tool_box', [
            'pt-BR'=>'Caixa de Ferramentas'
        ]);
        self::generateTranslation('info_php_cli', [
            'pt-BR'=>'é usado para realizar a conversão de vídeo em um processo em segundo plano.'
        ]);
        self::generateTranslation('info_media_info', [
            'pt-BR'=>'fornece informações técnicas e de marcação sobre um arquivo de vídeo ou áudio.'
        ]);
        self::generateTranslation('info_ffprobe', [
            'pt-BR'=>'é uma extensão do FFMPEG usada para obter informações do arquivo de mídia'
        ]);
        self::generateTranslation('info_php_web', [
            'pt-BR'=>'é usado para exibir esta página'
        ]);
        self::generateTranslation('must_be_least', [
            'pt-BR'=>'deve ser pelo menos'
        ]);
        self::generateTranslation('php_cli_not_found', [
            'pt-BR'=>'PHP CLI não está configurado corretamente'
        ]);
        self::generateTranslation('cache', [
            'pt-BR'=>'cache'
        ]);
        self::generateTranslation('enable_cache', [
            'pt-BR'=>'Ativar cache'
        ]);
        self::generateTranslation('enable_cache_authentification', [
            'pt-BR'=>'Ativar autenticação de cache'
        ]);
        self::generateTranslation('reset_cache_label', [
            'pt-BR'=>'Redefinir Cache'
        ]);
        self::generateTranslation('reset_cache_description', [
            'pt-BR'=>'Limpar todas as entradas do cache'
        ]);
        self::generateTranslation('nb_files', [
            'pt-BR'=>'Numero de arquivos'
        ]);
        self::generateTranslation('video_file_management', [
            'pt-BR'=>'Gerenciamento de arquivos de vídeo'
        ]);
        self::generateTranslation('confirm_delete_video_file', [
            'pt-BR'=>'Tem certeza de que deseja excluir a resolução %sp ?'
        ]);
    }
}