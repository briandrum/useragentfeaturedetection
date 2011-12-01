<?php

  Class Extension_UserAgentFeatureDetection extends Extension {

    public function about() {
      return array(
        'author'       => array(
          'email'    => 'brian@briandrum.net',
          'name'     => 'Brian Drum',
          'website'  => 'http://briandrum.net'
        ),
        'description'  => 'The User Agent Feature Detection extension makes information about user agent features available in the param pool for the purposes of responsive web design.',
        'name'         => 'User Agent Feature Detection',
        'release-date' => '2011-12-01',
        'version'      => '0.3'
      );
    }

    public function install() {
      Symphony::Configuration()->set('screen_detection_enabled', 'true', 'user_agent_feature_detection');
      Symphony::Configuration()->set('screen_default', 480, 'user_agent_feature_detection');
      Administration::instance()->saveConfig();
    }

    public function uninstall() {
      Symphony::Configuration()->remove('user_agent_feature_detection');
      Administration::instance()->saveConfig();
    }

    public function getSubscribedDelegates(){
      return array(
        array(
          'page'     => '/system/preferences/',
          'delegate' => 'AddCustomPreferenceFieldsets',
          'callback' => 'appendPreferences'
        ),
        array(
          'page'     => '/system/preferences/',
          'delegate' => 'Save',
          'callback' => 'savePreferences'
        ),
        array(
          'page'     => '/frontend/',
          'delegate' => 'FrontendParamsResolve',
          'callback' => 'addParam'
        )
      );
    }

    public function appendPreferences($context) {
      $uafd_fieldset = new XMLElement('fieldset');
      $uafd_fieldset->setAttribute('class', 'settings');
      $uafd_fieldset->appendChild(new XMLElement('legend', __('User Agent Feature Detection')));
      $context['wrapper']->appendChild($uafd_fieldset);

      $screen_detection_div = new XMLElement('div');
      $screen_detection_div->setAttribute('class', 'group');
      $uafd_fieldset->appendChild($screen_detection_div);

      $screen_detection_enabled_current = Symphony::Configuration()->get('screen_detection_enabled', 'user_agent_feature_detection');
      $screen_detection_enabled_select = Widget::Select('settings[feature][screen_detection_enabled]',
        array(
          array('true', ('true' == $screen_detection_enabled_current) ? true : false, "Enabled"),
          array('false', ('false' == $screen_detection_enabled_current) ? true : false, "Disabled")
        )
      );
      $screen_detection_enabled_label = Widget::Label('Screen Detection', $screen_detection_enabled_select);
      $screen_detection_div->appendChild($screen_detection_enabled_label);

      $screen_default_current = Symphony::Configuration()->get('screen_default', 'user_agent_feature_detection');
      $screen_default_input = Widget::Input('settings[feature][screen_default]', $screen_default_current, 'number',
        array(
          'min'   => 0,
          'step'  => 10
        ));
      $screen_default_label = Widget::Label('Default Screen Size (px) ', $screen_default_input);
      $screen_detection_div->appendChild($screen_default_label);

      $help = new XMLElement('p', __('Default values are for user agents without JavaScript or with cookies disabled.'));
      $help->setAttribute('class', 'help');
      $uafd_fieldset->appendChild($help);
    }

    public function addParam($context) {

      // feature_detection cookie
      $feature_detection  = !empty($_COOKIE['feature_detection']) ? $_COOKIE['feature_detection'] : 0;
      $context['params']['feature-detection'] = $feature_detection;

      // screen_max cookie
      if (Symphony::Configuration()->get('screen_detection_enabled', 'user_agent_feature_detection') === 'true') {
        $feature_screen_max_fallback = Symphony::Configuration()->get('screen_default', 'user_agent_feature_detection');
        $feature_screen_max = !empty($_COOKIE['feature_screen_max']) ? $_COOKIE['feature_screen_max'] : $feature_screen_max_fallback;
        $context['params']['feature-screen-max'] = $feature_screen_max;
      }

      // screen_min cookie
      if (Symphony::Configuration()->get('screen_detection_enabled', 'user_agent_feature_detection') === 'true') {
        $feature_screen_min_fallback = Symphony::Configuration()->get('screen_default', 'user_agent_feature_detection');
        $feature_screen_min = !empty($_COOKIE['feature_screen_min']) ? $_COOKIE['feature_screen_min'] : $feature_screen_min_fallback;
        $context['params']['feature-screen-min'] = $feature_screen_min;
      }

      // screen_orientation cookie
      if (Symphony::Configuration()->get('screen_detection_enabled', 'user_agent_feature_detection') === 'true') {
        $feature_screen_orientation = !empty($_COOKIE['feature_screen_orientation']) ? $_COOKIE['feature_screen_orientation'] : 'fallback';
        $context['params']['feature-screen-orientation'] = $feature_screen_orientation;
      }

    }

  }

?>
