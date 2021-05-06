<?php

// ARCHIVO DEL BOTON VOLVER A LA PAGINA INICIAL

                session_start(); // Esta debe ser siempre la primera instrucción

                $url = '';
                switch ($_SESSION['rol']) {
                    case 1:
                        $url = '../ingreso/interfaz_superadmin.php';
                        break;
                    case 2:
                        $url = '../ingreso/interfaz_admin.php';
                        break;
                    case 3:
                        $url = '../ingreso/interfaz_operario.php';
                        break;
                }
                // Mostrar botón
                echo "<a href=\"$url\" class='btn btn-light rounded'><i class='fas fa-home'></i></a>";
