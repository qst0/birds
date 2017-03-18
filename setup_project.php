<?php

if ($argc !== 4)
{
	echo "Usage: php " .$argv[0]." <vog git url> <new github repo name> <project language>\n"
	. "Languages: C PHP JAVA\n"
	. "This will create a repo on github with the new name\n"
	. "Then connect it to your repo on the vog\n"
	. "Then setup the project enviorment based on the project language\n";
}
else if ($argc === 4)
{
	$vog_url = $argv[1];
	$name = $argv[2];
	$lang = $argv[3];
	system("git clone ".$argv[1]." ".$argv[2]);
	system("curl -i -H 'Authorization: token 2f09d631b428b61060991d85957a6b45ab16199b' -d '{ \"name\": \"$name\" }' https://api.github.com/user/repos");
	$gh_url = "https://github.com/qst0/$name";
	echo $gh_url;
	$git_in_repo = "git --git-dir=$name/.git --work-tree=$name";
	system("$git_in_repo remote set-url --add --push origin $gh_url");
	system("$git_in_repo remote set-url --add --push origin $vog_url");
	system("echo 'myoung' > $name/author");
	system("echo '#$name' > $name/README.md");
	if ($lang === "C")
	{
		system("mkdir $name/src");
		system("mkdir $name/include");
		system("curl http://qst0.com/Makefile > $name/Makefile");	
		system("$git_in_repo add Makefile");
	}
	system("curl http://qst0.com/gitignore > $name/.gitignore");	
	system("$git_in_repo add README.md author .gitignore");
	system("$git_in_repo commit -m \"Project init\"");
	system("$git_in_repo push -u origin master");
}	
?>
