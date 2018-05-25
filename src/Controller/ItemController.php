<?php

namespace Controller;

class ItemController extends AbstractController
{

    /**
     * Display view index
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function indexAction()
    {

        return $this->twig->render('/Item/index.html.twig');
    }

    /**
     * Display view Planning & Tarifs
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function productsAction()
    {
        return $this->twig->render('/Item/products.html.twig');
    }

    /**
     * Display view Programme
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function servicesAction()
    {
        return $this->twig->render('/Item/services.html.twig');
    }

    /**
     * Display view Ecoles
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function contactAction()
    {
        $this->twig->getExtensions(session_start());
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->getExtensions(session_unset());
        $errors = array();

        if ($_POST)
        {
            //Lastname error management//
            if (empty($_POST['lastname']))
            {
                $errors['lastname'] = "*Veuillez renseigner votre nom.";
            }

            elseif (!preg_match("#([a-zA-Z]{2,32}\s*)+#", $_POST['lastname']))
            {
                $errors['lastname'] = "*Veuillez renseigner un nom valide, compris entre 2 et 32 caractères";
            }
            //End of lastname error management//

            //Firstname error management//
            if (empty($_POST['firstname']))
            {
                $errors['firstname'] = "*Veuillez renseigner votre prénom.";
            }

            elseif (!preg_match("#([a-zA-Z]{2,32}\s*)+#", $_POST['firstname']))
            {
                $errors['firstname'] = "*Veuillez renseigner un prénom valide, compris entre 2 et 32 caractères";
            }
            //End of firstname error management//

            //E-mail error management//
            if (empty($_POST['email']))
            {
                $errors['email'] = "*Veuillez renseigner votre e-mail.";
            }
            if (!preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email']))
            {
                $errors['email'] = "*Veuillez renseigner une adresse e-mail valide";
            }
            //End of e-mail error management//

            //Phone error management//
            if (empty($_POST['phone']))
            {
                $errors['phone'] = "*Veuillez renseigner votre numéro de téléphone.";
            }
            if (!preg_match("#^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$#",
                $_POST['phone']))
            {
                $errors["phone"] = "*Veuillez renseigner un numéro de téléphone valide";
            }
            //End of phone error management//

            //Message error management//
            if (empty($_POST['message']))
            {
                $errors['message'] = "*Laissez nous un message.";
            }
            elseif (strlen($_POST['message']) < 2 || strlen($_POST['message']) > 600)
            {
                $errors['message'] = "*Votre message doit comprendre entre 2 et 6OO caractères";
            }
            //End of message error management//

            if (count($errors) > 0 )
            {
                $_SESSION['errors'] = $errors;
                $_SESSION['inputs'] = $_POST;
                header('Location: /rendezvous#contact');
            }

            else
            {
                $_SESSION['success'] = 1;

                $headers = "From:".$_POST['email']."\n";
                $headers .= "MIME-version: 1.0\n";
                $headers .= "Content-type: text/html; charset= iso-8859-1\n";

                $contenu = '<html>';
                $contenu .='<head>';
                $contenu .='<title>Mon espace perruques</title>';
                $contenu .='</head>';
                $contenu .='<body>';
                $contenu .='<p>Ce mail vous a été envoyé suite à une prise de contact via le formulaire de monespaceperruques.com </p>';
                $contenu .='<table>';
                $contenu .='<tr><th>Nom:</th>';
                $contenu .='<td>';
                $contenu .= $_POST['lastname'];
                $contenu .='</td>';
                $contenu .='</tr>';
                $contenu .='<tr><th>Prénom:</th>';
                $contenu .='<td>';
                $contenu .= $_POST['firstname'];
                $contenu .='</td>';
                $contenu .='</tr>';
                $contenu .='<tr><th>Téléphone:</th>';
                $contenu .='<td>';
                $contenu .= $_POST['phone'];
                $contenu .='</td>';
                $contenu .='</tr>';
                $contenu .='<tr><th>Objet:</th>';
                $contenu .='<td>';
                $contenu .= $_POST['Objet'];
                $contenu .='</td>';
                $contenu .='</tr>';
                $contenu .='<tr><th>Message:</th>';
                $contenu .='<td>';
                $contenu .= $_POST['message'];
                $contenu .='</td>';
                $contenu .='</tr>';
                $contenu .='</table>';
                $contenu .='</body>';
                $contenu .='</html>';

                mail('cannelle.legrand14@gmail.com', 'Formulaire de contact de' .' '.$_POST['lastname'] .' '. $_POST['firstname'], $contenu, $headers);
                unset($_POST);
                header('Location: /rendezvous#contact');
            }
        }
        return $this->twig->render('Item/contact.html.twig', [
            'errors' => $errors,
            'post' => $_POST = !$_POST ? null : $_POST,
        ]);
    }

    /**
     * Display view Mentions Légales & CGU
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function legalsAction()
    {
        return $this->twig->render('/Item/legals.html.twig');
    }

    /**
     * Display view CGV
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function partnersAction()
    {
        return $this->twig->render('/Item/partners.html.twig');
    }

    /**
     *
     * Display view Erreur 404
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function error404Action()
    {
        return $this->twig->render('/Item/404error.html.twig');
    }
}
