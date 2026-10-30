<?php

namespace V5_5_3;

use cbpage;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_audio_tracks` (
            `videoid` BIGINT(20) NOT NULL,
            `track_number` TINYINT NULL,
            `title` VARCHAR(64) NOT NULL,
            `order` TINYINT NOT NULL,
            PRIMARY KEY (`videoid`, `track_number`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        self::alterTable('ALTER TABLE `{tbl_prefix}video_audio_tracks` ADD CONSTRAINT `video_audio_tracks_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE NO ACTION;', [
            'table' => 'video_audio_tracks',
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_audio_tracks_ibfk_1'
            ]
        ]);

        self::generateConfig('audio_api_notification', 'no');

        self::generateTranslation('config_audio_api_notification', [
            'fr' => 'Activer la notification de l’API Audio lorsque cela est pertinent.',
            'en' => 'Enable Audio API notification when relevant.'
        ]);
        self::generateTranslation('config_audio_api_notification_hint', [
            'fr' => 'Affiche une notification discrète si une vidéo MP4 dispose de plusieurs pistes audio mais que l’API navigateur n’est pas disponible',
            'en' => 'Display a subtle notification when an MP4 video contains multiple audio tracks but the browser API is not available'
        ]);
        self::generateTranslation('audio_api_notification', [
            'fr' => 'Cette vidéo dispose de plusieurs pistes audio, mais votre navigateur n\'est pas configuré pour pouvoir y accéder ; cliquez %s pour plus d\'informations.',
            'en' => 'This video contains multiple audio tracks, but your browser is not configured to access them. Click %s for more information.'
        ]);
        self::generateTranslation('video_audio_track_list_management', [
            'fr' => 'Pistes audios',
            'en' => 'Audio tracks'
        ]);


        if (empty(Cbpage::getInstance()->get_pages(['page_name' => 'activate_audio_api']))) {
            $name = 'activate_audio_api';
            $title = [
                \Language::$english_id => 'How to activate AudioTrack API',
                2                      => 'Comment activer l\'API AudioTrack'
            ];
            $content = [
                \Language::$english_id => '<div class="col-xs-12" lang="en">
  <div class="page-header">
    <h1 style="font-size: 36px;">How to activate AudioTrack API</p>
    <h3>Choose a video’s audio language</h1>
    <p class="lead">Some videos offer multiple audio tracks. To select them, your browser may need an additional setting.</p>
    <p>The <code>audioTracks</code> API allows the player to access the audio tracks recognized by the browser. Its availability depends on the browser, video format and playback mode.</p>
    <p class="small text-muted"><a href="https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/audioTracks">audioTracks API (MDN)</a></p>
  </div>


  <div class="alert alert-warning">
    <p><strong>Before changing a setting</strong></p>
    <p>Experimental options in Chrome, Edge and Opera also enable other features, across all websites. They may cause problems. Note the original value so you can restore it. The website cannot enable these options for you.</p>
  </div>

  <h2>Instructions by browser</h2>
  <p>Read the section for the browser you use. Internal addresses must be copied into its address bar, then opened by pressing Enter or Go.</p>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Google Chrome</h2>
      <p class="small text-muted">Desktop and Android · Experimental option</p>
    </div>
    <div class="panel-body">
      <ol>
        <li>Copy this address into a new tab:<br><code>chrome://flags/#enable-experimental-web-platform-features</code></li>
        <li>Find <strong>Experimental Web Platform features</strong> and select <strong>Enabled</strong> (enabled).</li>
        <li>Save your work in other tabs, then use <strong>Relaunch</strong> to restart the browser.</li>
        <li>Return to the website, reload the video and try the player’s audio track menu, if available.</li>
      </ol>
      <p class="small text-muted">To undo: restore the original value, usually <strong>Default</strong>, then restart Chrome. This procedure does not apply to Chrome on iPhone or iPad.</p>
      <p class="small text-muted"><a href="https://developer.chrome.com/docs/web-platform/chrome-flags">Experimental options (Chrome)</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Microsoft Edge</h2>
      <p class="small text-muted">Desktop · Experimental option</p>
    </div>
    <div class="panel-body">
      <ol>
        <li>Open this address in Edge:<br><code>edge://flags/#enable-experimental-web-platform-features</code></li>
        <li>Set <strong>Experimental Web Platform features</strong> to <strong>Enabled</strong>.</li>
        <li>Save your work and click the restart button provided.</li>
        <li>Reload the video, then try switching the audio track in the player.</li>
      </ol>
      <p class="small text-muted">To undo: restore the original value, usually <strong>Default</strong>, then restart Edge. This option is not guaranteed to be available on mobile.</p>
      <p class="small text-muted"><a href="https://github.com/mdn/browser-compat-data/blob/main/api/HTMLMediaElement.json">MDN compatibility data</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Mozilla Firefox</h2>
      <p class="small text-muted">Desktop · Limited support</p>
    </div>
    <div class="panel-body">
      <p><strong>Enabling the API is not enough to make multitrack playback work.</strong> Mozilla states that Firefox does not support multiple audio/video tracks in this context. This setting may expose the API without allowing you to choose another language.</p>
      <p>To enable access to the API only:</p>
      <ol>
        <li>Type <code>about:config</code> in the address bar.</li>
        <li>Read the warning and continue if you want to change this advanced setting.</li>
        <li>Search for <code>media.track.enabled</code>.</li>
        <li>If this preference exists, set its value to <strong>true</strong>, then reload the video. If it is missing, do not create it: doing so does not guarantee support.</li>
      </ol>
      <p class="small text-muted">To undo: restore the previous value. This guide does not provide a reliable procedure for Firefox on Android; access to advanced settings varies by edition.</p>
      <p class="small text-muted"><a href="https://developer.mozilla.org/en-US/docs/Mozilla/Firefox/Experimental_features#htmlmediaelement_properties_audiotracks_and_videotracks">Firefox limitations (Mozilla)</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Apple Safari</h2>
      <p class="small text-muted">Mac, iPhone and iPad · No activation required</p>
    </div>
    <div class="panel-body">
      <p>Safari supports the <code>audioTracks</code> API without enabling experimental features.</p>
      <ol>
        <li>Open the video in Safari and start playback.</li>
        <li>Open the player’s audio track menu, if it appears, and choose your preferred language.</li>
      </ol>
      <p>If the menu is missing, check that the video has multiple usable tracks. Their availability also depends on the format and the player used by the website.</p>
      <p class="small text-muted"><a href="https://github.com/mdn/browser-compat-data/blob/main/api/HTMLMediaElement.json">MDN compatibility data</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Opera</h2>
      <p class="small text-muted">Desktop · Experimental option</p>
    </div>
    <div class="panel-body">
      <ol>
        <li>Open this address in Opera:<br><code>opera://flags/#enable-experimental-web-platform-features</code></li>
        <li>If the <strong>Experimental Web Platform features</strong> option is available, select <strong>Enabled</strong>.</li>
        <li>Save your work, restart Opera using the button provided and reload the video.</li>
      </ol>
      <p class="small text-muted">To undo: restore the original value, usually <strong>Default</strong>, then restart Opera. Do not apply this procedure to Opera Mini or mobile editions without checking that the option is available.</p>
      <p class="small text-muted"><a href="https://github.com/mdn/browser-compat-data/blob/main/api/HTMLMediaElement.json">MDN compatibility data</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Brave</h2>
      <p class="small text-muted">Desktop · Experimental option</p>
    </div>
    <div class="panel-body">
      <ol>
        <li>Open this address in Brave:<br><code>brave://flags/#enable-experimental-web-platform-features</code></li>
        <li>If the <strong>Experimental Web Platform features</strong> option is available, select <strong>Enabled</strong>.</li>
        <li>Save your work, restart Brave using the button provided and reload the video.</li>
        <li>Try the player’s audio track menu, if available.</li>
      </ol>
      <p>This procedure relies on experimental options inherited from Chromium. Their availability and multitrack functionality are not guaranteed in every version of Brave.</p>
      <p class="small text-muted">To undo: restore the original value, usually <strong>Default</strong>, then restart Brave. This procedure does not apply to Brave on iPhone or iPad.</p>
      <p class="small text-muted"><a href="https://github.com/chromium/chromium/blob/main/third_party/blink/renderer/platform/RuntimeEnabledFeatures.md">Chromium engine experimental options</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Other browsers and mobile devices</h2>
    </div>
    <div class="panel-body">
      <p><strong>iPhone and iPad:</strong> the desktop settings procedures for Chrome, Edge and Firefox do not apply as written. If you encounter a problem, open the same video in Safari, where the API is available without this setting.</p>
      <p><strong>Vivaldi, Samsung Internet and other browsers:</strong> a shared browser engine alone does not guarantee that the setting exists or works. If the API is missing and your browser offers no documented option, there is no universal way to enable it from the website.</p>
    </div>
  </div>

  <div class="well">
    <h2>Still no other audio track?</h2>
    <ul>
      <li><strong>Restart, then reload:</strong> after changing an experimental setting, closing a single tab is not a substitute for restarting the browser.</li>
      <li><strong>Check the video:</strong> not all videos offer multiple languages. An accessible API does not add tracks to a file.</li>
      <li><strong>Cannot find the option:</strong> it may be missing from your version or blocked on a managed device. Do not change other options at random.</li>
      <li><strong>API accessible, but no menu:</strong> the format, codecs or the website’s playback mode may limit the available tracks. Tell support which video is affected, along with your browser, its version and your device.</li>
    </ul>
    <p>These settings concern audio track selection, not volume, subtitles or speaker selection.</p>
  </div>

  <hr>
  <div class="small text-muted">
    <p>Documentation consulted on October 29, 2026. Browser options may change.</p>
  </div>
</div> ',
                2                      => '<div class="col-xs-12" lang="fr">
  <div class="page-header">
     <h1 style="font-size: 36px;">Comment activer l\'API AudioTrack</h1>
    <h3>Choisir la langue audio d’une vidéo</h3>
    <p class="lead">Certaines vidéos proposent plusieurs pistes audio. Pour les sélectionner, votre navigateur peut avoir besoin d’un réglage supplémentaire.</p>
    <p>L’API <code>audioTracks</code> permet au lecteur d’accéder aux pistes audio reconnues par le navigateur. Sa disponibilité dépend du navigateur, du format de la vidéo et du mode de lecture.</p>
    <p class="small text-muted"><a href="https://developer.mozilla.org/en-US/docs/Web/API/HTMLMediaElement/audioTracks">API audioTracks (MDN)</a></p>
  </div>


  <div class="alert alert-warning">
    <p><strong>Avant de modifier un réglage</strong></p>
    <p>Les options expérimentales de Chrome, Edge et Opera activent aussi d’autres fonctions, pour l’ensemble des sites. Elles peuvent provoquer des dysfonctionnements. Notez la valeur initiale pour pouvoir la restaurer. Le site ne peut pas activer ces options à votre place.</p>
  </div>

  <h2>Instructions par navigateur</h2>
  <p>Consultez la rubrique correspondant au navigateur que vous utilisez. Les adresses internes doivent être copiées dans sa barre d’adresse, puis validées.</p>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Google Chrome</h2>
      <p class="small text-muted">Ordinateur et Android · Option expérimentale</p>
    </div>
    <div class="panel-body">
      <ol>
        <li>Copiez cette adresse dans un nouvel onglet :<br><code>chrome://flags/#enable-experimental-web-platform-features</code></li>
        <li>Repérez <strong>Experimental Web Platform features</strong> et choisissez <strong>Enabled</strong> (activé).</li>
        <li>Enregistrez votre travail dans les autres onglets, puis utilisez <strong>Relaunch</strong> pour relancer le navigateur.</li>
        <li>Revenez sur le site, rechargez la vidéo et essayez le menu des pistes audio du lecteur, s’il est proposé.</li>
      </ol>
      <p class="small text-muted">Pour annuler : restaurez la valeur initiale, généralement <strong>Default</strong>, puis relancez Chrome. Cette procédure ne concerne pas Chrome sur iPhone ou iPad.</p>
      <p class="small text-muted"><a href="https://developer.chrome.com/docs/web-platform/chrome-flags">Options expérimentales (Chrome)</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Microsoft Edge</h2>
      <p class="small text-muted">Ordinateur · Option expérimentale</p>
    </div>
    <div class="panel-body">
      <ol>
        <li>Ouvrez cette adresse dans Edge :<br><code>edge://flags/#enable-experimental-web-platform-features</code></li>
        <li>Réglez <strong>Experimental Web Platform features</strong> sur <strong>Enabled</strong>.</li>
        <li>Enregistrez votre travail et cliquez sur le bouton de redémarrage proposé.</li>
        <li>Rechargez la vidéo, puis essayez de changer la piste audio dans le lecteur.</li>
      </ol>
      <p class="small text-muted">Pour annuler : restaurez la valeur initiale, généralement <strong>Default</strong>, puis redémarrez Edge. La disponibilité de cette option sur mobile n’est pas garantie.</p>
      <p class="small text-muted"><a href="https://github.com/mdn/browser-compat-data/blob/main/api/HTMLMediaElement.json">Données de compatibilité MDN</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Mozilla Firefox</h2>
      <p class="small text-muted">Ordinateur · Prise en charge limitée</p>
    </div>
    <div class="panel-body">
      <p><strong>Activer l’API ne suffit pas à rendre la lecture multipiste opérationnelle.</strong> Mozilla indique que Firefox ne prend pas en charge plusieurs pistes audio/vidéo dans ce cadre. Ce réglage peut exposer l’API sans permettre de choisir une autre langue.</p>
      <p>Pour activer uniquement l’accès à l’API :</p>
      <ol>
        <li>Saisissez <code>about:config</code> dans la barre d’adresse.</li>
        <li>Lisez l’avertissement et continuez si vous souhaitez modifier ce réglage avancé.</li>
        <li>Recherchez <code>media.track.enabled</code>.</li>
        <li>Si cette préférence existe, passez sa valeur à <strong>true</strong>, puis rechargez la vidéo. Si elle est absente, ne la créez pas : cela ne garantit pas la prise en charge.</li>
      </ol>
      <p class="small text-muted">Pour annuler : restaurez la valeur précédente. Ce guide ne propose pas de procédure fiable pour Firefox sur Android ; l’accès aux réglages avancés varie selon l’édition.</p>
      <p class="small text-muted"><a href="https://developer.mozilla.org/en-US/docs/Mozilla/Firefox/Experimental_features#htmlmediaelement_properties_audiotracks_and_videotracks">Limites de Firefox (Mozilla)</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Apple Safari</h2>
      <p class="small text-muted">Mac, iPhone et iPad · Pas d’activation requise</p>
    </div>
    <div class="panel-body">
      <p>Safari prend en charge l’API <code>audioTracks</code> sans activation expérimentale.</p>
      <ol>
        <li>Ouvrez la vidéo dans Safari et lancez sa lecture.</li>
        <li>Ouvrez le menu des pistes audio du lecteur, s’il apparaît, et choisissez la langue souhaitée.</li>
      </ol>
      <p>Si le menu est absent, vérifiez que la vidéo possède plusieurs pistes utilisables. Leur disponibilité dépend aussi du format et du lecteur utilisé par le site.</p>
      <p class="small text-muted"><a href="https://github.com/mdn/browser-compat-data/blob/main/api/HTMLMediaElement.json">Données de compatibilité MDN</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Opera</h2>
      <p class="small text-muted">Ordinateur · Option expérimentale</p>
    </div>
    <div class="panel-body">
      <ol>
        <li>Ouvrez cette adresse dans Opera :<br><code>opera://flags/#enable-experimental-web-platform-features</code></li>
        <li>Si l’option <strong>Experimental Web Platform features</strong> est disponible, choisissez <strong>Enabled</strong>.</li>
        <li>Enregistrez votre travail, relancez Opera avec le bouton proposé et rechargez la vidéo.</li>
      </ol>
      <p class="small text-muted">Pour annuler : restaurez la valeur initiale, généralement <strong>Default</strong>, puis relancez Opera. Ne transposez pas cette procédure à Opera Mini ou aux éditions mobiles sans vérifier la présence de l’option.</p>
      <p class="small text-muted"><a href="https://github.com/mdn/browser-compat-data/blob/main/api/HTMLMediaElement.json">Données de compatibilité MDN</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Brave</h2>
      <p class="small text-muted">Ordinateur · Option expérimentale</p>
    </div>
    <div class="panel-body">
      <ol>
        <li>Ouvrez cette adresse dans Brave :<br><code>brave://flags/#enable-experimental-web-platform-features</code></li>
        <li>Si l’option <strong>Experimental Web Platform features</strong> est disponible, choisissez <strong>Enabled</strong>.</li>
        <li>Enregistrez votre travail, relancez Brave avec le bouton proposé et rechargez la vidéo.</li>
        <li>Essayez le menu des pistes audio du lecteur, s’il est proposé.</li>
      </ol>
      <p>Cette procédure repose sur les options expérimentales héritées de Chromium. Leur disponibilité et le fonctionnement du multipiste ne sont pas garantis dans toutes les versions de Brave.</p>
      <p class="small text-muted">Pour annuler : restaurez la valeur initiale, généralement <strong>Default</strong>, puis relancez Brave. Cette procédure ne concerne pas Brave sur iPhone ou iPad.</p>
      <p class="small text-muted"><a href="https://github.com/chromium/chromium/blob/main/third_party/blink/renderer/platform/RuntimeEnabledFeatures.md">Options expérimentales du moteur Chromium</a></p>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h2 class="panel-title">Autres navigateurs et appareils mobiles</h2>
    </div>
    <div class="panel-body">
      <p><strong>iPhone et iPad :</strong> les procédures de réglage pour Chrome, Edge et Firefox sur ordinateur ne s’appliquent pas telles quelles. Si vous rencontrez un problème, ouvrez la même vidéo dans Safari, où l’API est disponible sans ce réglage.</p>
      <p><strong>Vivaldi, Samsung Internet et autres navigateurs :</strong> leur moteur commun éventuel ne suffit pas à garantir la présence du réglage ou son fonctionnement. Si l’API est absente et qu’aucune option documentée n’est proposée par votre navigateur, il n’existe pas d’activation universelle depuis le site.</p>
    </div>
  </div>

  <div class="well">
    <h2>Toujours aucune autre piste audio ?</h2>
    <ul>
      <li><strong>Relancez puis rechargez :</strong> après une modification expérimentale, fermer un seul onglet ne remplace pas le redémarrage du navigateur.</li>
      <li><strong>Vérifiez la vidéo :</strong> toutes les vidéos ne proposent pas plusieurs langues. Une API accessible n’ajoute pas de piste à un fichier.</li>
      <li><strong>Option introuvable :</strong> elle peut être absente de votre version ou bloquée sur un appareil administré. Ne modifiez pas d’autres options au hasard.</li>
      <li><strong>API accessible, mais menu absent :</strong> le format, les codecs ou le mode de lecture du site peuvent limiter les pistes disponibles. Signalez au support la vidéo concernée, votre navigateur, sa version et votre appareil.</li>
    </ul>
    <p>Ces réglages concernent la sélection d’une piste audio, pas le volume, les sous-titres ou le choix des haut-parleurs.</p>
  </div>

  <hr>
  <div class="small text-muted">
    <p>Documentation consultée le 29 octobre 2026. Les options des navigateurs peuvent évoluer.</p>
  </div>
</div> '
            ];

            $fields = ['page_name', 'userid', 'date_added', 'active', 'page_order', 'delete_able', 'display'];
            $values = [$name, \User::getInstance()->getCurrentUserID(), now(), 'yes', Cbpage::getInstance()->getMaxPageOrder(), 'no', 'no'];
            $insert_id = \Clipbucket_db::getInstance()->insert(tbl(Cbpage::getInstance()->page_tbl), $fields, $values);
            if (\Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '184')) {
                foreach ($content as $lang_id => $content_trad) {
                    Cbpage::getInstance()->insertOrUpdatePageTranslation($insert_id, $lang_id, $title[$lang_id], $content_trad);
                }
            }
        }
    }
}
