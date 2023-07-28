SET @language_id_por = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');

INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'admin_tool'), 'Ferramentas Administrativas', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'launch'), 'Iniciar', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'stop'), 'Parar', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'in_progress'), 'Em progresso', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'ready'), 'Pronto', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'stopping'), 'Parando', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'generate_missing_thumbs_label'), 'Gerar miniaturas faltantes', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'generate_missing_thumbs_description'), 'Gerar miniaturas para os vídeos sem uma miniatura', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_castable_status_label'), 'Atualizar status de vídeos transmissíveis', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_castable_status_description'), 'Atualize o status de todos os vídeos que podem ser transmitidos com base nos arquivos de vídeo', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_bits_color_label'), 'Atualizar status de codificação de cores dos vídeos', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_bits_color_description'), 'Atualize o status de codificação de cores de todos os vídeos, com base nos arquivos de vídeo', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_videos_duration_label'), 'Atualizar as durações dos vídeos', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_videos_duration_description'), 'Atualize todas as durações dos vídeos, com base nos arquivos de vídeo', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'need_db_upgrade'), 'Você tem <b>%s</b> arquivos para executar para poder atualizar seu banco de dados. Você pode usar este link a seguir: ', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'db_up_to_date'), 'Seu banco de dados está atualizado', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_database_version_label'), 'Atualizar seu banco de dados para a versão atual', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'update_database_version_description'), 'Execute todos os arquivos SQL necessários para atualizar o banco de dados', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'no_version'), 'Seu ClipBucket usa o antigo sistema de atualização de banco de dados. Execute todos os arquivos de migração SQL para a versão 5.3.0 antes de continuar.', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'select_version'), 'Por favor, selecione sua versão atual e a revisão', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'version'), 'versão', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'revision'), 'revisão', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'system_info'), 'Informações do Sistema', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'hosting'), 'Hospedagem', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_ffmpeg'), 'é usado para converter vídeos de diferentes versões para FLV, MP4 e muitos outros formatos.', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'tool_box'), 'Caixa de Ferramentas', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_php_cli'), 'é usado para realizar a conversão de vídeo em um processo em segundo plano.', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_media_info'), 'fornece informações técnicas e de marcação sobre um arquivo de vídeo ou áudio.', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_ffprobe'), 'é uma extensão do FFMPEG usada para obter informações do arquivo de mídia', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'info_php_web'), 'é usado para exibir esta página', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'must_be_least'), 'deve ser pelo menos', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'php_cli_not_found'), 'PHP CLI não está configurado corretamente', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'cache'), 'cache', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_cache'), 'Ativar cache', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'enable_cache_authentification'), 'Ativar autenticação de cache', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_cache_label'), 'Redefinir Cache', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'reset_cache_description'), 'Limpar todas as entradas do cache', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'nb_files'), 'Numero de arquivos', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'video_file_management'), 'Gerenciamento de arquivos de vídeo', @language_id_por);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES ((SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'confirm_delete_video_file'), 'Tem certeza de que deseja excluir a resolução %sp ?', @language_id_por);
