<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00221 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('reset_video_log_label', [
            'pt-BR' => 'Deletar logs de conversão'
        ]);
        self::generateTranslation('reset_video_log_description', [
            'pt-BR' => 'Deletar o log de conversão de vídeos convertidos com sucesso'
        ]);
        self::generateTranslation('no_conversion_log', [
            'pt-BR' => 'Nenhum arquivo de log de conversão dísponivel'
        ]);
        self::generateTranslation('watch_conversion_log', [
            'pt-BR' => 'Ver o log de conversão'
        ]);
        self::generateTranslation('conversion_log', [
            'pt-BR' => 'Log de conversão'
        ]);
        self::generateTranslation('open_debug', [
            'pt-BR' => 'Solicitações SQL'
        ]);
        self::generateTranslation('select_queries', [
            'pt-BR' => 'Selecionar Consultas'
        ]);
        self::generateTranslation('update_queries', [
            'pt-BR' => 'Atualizar Consultas'
        ]);
        self::generateTranslation('delete_queries', [
            'pt-BR' => 'Atualizar Consultas'
        ]);
        self::generateTranslation('insert_queries', [
            'pt-BR' => 'Atualizar Consultas'
        ]);
        self::generateTranslation('execute_queries', [
            'pt-BR' => 'Atualizar Consultas'
        ]);
        self::generateTranslation('expensive_query', [
            'pt-BR' => 'Consultas Caras'
        ]);
        self::generateTranslation('cheapest_query', [
            'pt-BR' => 'Consultas Baratas'
        ]);
        self::generateTranslation('overall_stats', [
            'pt-BR' => 'Estatísticas Gerais'
        ]);
        self::generateTranslation('base_directory', [
            'pt-BR' => 'Diretório base'
        ]);
        self::generateTranslation('queries', [
            'pt-BR' => 'Consultas'
        ]);
        self::generateTranslation('all_queries', [
            'pt-BR' => 'Todas as consultas'
        ]);
        self::generateTranslation('total_db_queries', [
            'pt-BR' => 'Total de Consultas em BD'
        ]);
        self::generateTranslation('total_cache_queries', [
            'pt-BR' => 'Total de Consultas em Cache'
        ]);
        self::generateTranslation('total_execution_time', [
            'pt-BR' => 'Tempo Total de Execução'
        ]);
        self::generateTranslation('total_memory_used', [
            'pt-BR' => 'Total de Memória Usada'
        ]);
        self::generateTranslation('memory_usage', [
            'pt-BR' => 'Uso de Memória'
        ]);
        self::generateTranslation('everything', [
            'pt-BR' => 'Tudo'
        ]);
        self::generateTranslation('display', [
            'pt-BR' => 'Exibir'
        ]);
        self::generateTranslation('disable_email', [
            'pt-BR' => 'Desativar Emails'
        ]);
        self::generateTranslation('number', [
            'pt-BR' => 'Número'
        ]);
        self::generateTranslation('confirm_delete_subtitle_file', [
            'pt-BR' => 'Tem certeza de que deseja excluir a faixa de legenda n°%s ?'
        ]);
        self::generateTranslation('video_subtitle_management', [
            'pt-BR' => 'Gerenciar legendas do vídeo'
        ]);
        self::generateTranslation('video_subtitles_deleted_num', [
            'pt-BR' => 'A faixa de legenda n°%s foi excluída'
        ]);
        self::generateTranslation('waiting', [
            'pt-BR' => 'Aguardando'
        ]);
        self::generateTranslation('option_enable_country', [
            'pt-BR' => 'Ativar seleção de País'
        ]);
        self::generateTranslation('option_enable_gender', [
            'pt-BR' => 'Ativar seleção de Sexo'
        ]);
        self::generateTranslation('option_enable_user_category', [
            'pt-BR' => 'Ativar seleção de Categoria de Usuário'
        ]);
        self::generateTranslation('video_upload_disabled', [
            'pt-BR' => 'O Envio de Vídeos foi desativado'
        ]);
        self::generateTranslation('plugin_compatible', [
            'pt-BR' => 'Plugin compativel com a versão atual do Clipbucket'
        ]);
        self::generateTranslation('plugin_not_compatible', [
            'pt-BR' => 'Plugin não compativel com a versão atual do Clipbucket'
        ]);
        self::generateTranslation('clean_orphan_files_label', [
            'pt-BR' => 'Excluir Arquivos Orfãos'
        ]);
        self::generateTranslation('clean_orphan_files_description', [
            'pt-BR' => 'Excluir arquivos de vídeos, legendas, miniaturas e arquivos de logs que não estejam relacionados a entradas no banco de dados'
        ]);
        self::generateTranslation('lang_restored', [
            'pt-BR' => 'O idioma %s foi restaurado com sucesso.'
        ]);
        self::generateTranslation('language_name', [
            'pt-BR' => 'Nome do Idioma'
        ]);
        self::generateTranslation('restore_language', [
            'pt-BR' => 'Restaurar idioma'
        ]);
        self::generateTranslation('restore', [
            'pt-BR' => 'Restaurar'
        ]);
    }
}