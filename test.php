<div id="welcome-screen">
    <style>
        #welcome-screen {
            position: fixed;
            overflow: hidden;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 99999;
            background: #fff;
        }

        #welcome-screen-background {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: #9CF4FD;
        }

        #welcome-screen-foreground {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #welcome-screen-logo {
            position: relative;
            overflow: hidden;
            width: 120px;
            height: 120px;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #welcome-screen-logo-image {
            max-width: 100%;
            max-height: 100%;
        }

        #welcome-screen-logo-cover {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: #9CF4FD;
            opacity: 0;
        }

        #welcome-screen.welcome-screen-state-bg-intro>#welcome-screen-foreground {
            display: none;
        }

        #welcome-screen.welcome-screen-state-outro {
            background: none;
        }

        .welcome-screen-state-logo-intro #welcome-screen-logo {
            animation: welcome-screen-logo-intro-logo 1ms both ease;
        }

        @keyframes welcome-screen-logo-intro-logo {
            0% {}

            100% {}
        }

        .welcome-screen-state-outro #welcome-screen-logo {
            animation: welcome-screen-outro-logo 300ms 0ms both ease;
        }

        @keyframes welcome-screen-outro-logo {
            0% {
                opacity: 1
            }

            100% {
                opacity: 0
            }
        }

        .welcome-screen-state-bg-intro #welcome-screen-background {
            animation: welcome-screen-bg-intro-background 900ms both cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        @keyframes welcome-screen-bg-intro-background {
            0% {
                transform: scaleX(0);
            }

            100% {
                transform: scaleX(1);
            }
        }

        .welcome-screen-state-outro #welcome-screen-background {
            animation: welcome-screen-outro-background 900ms reverse both cubic-bezier(0.645, 0.045, 0.355, 1);
        }

        @keyframes welcome-screen-outro-background {
            0% {
                transform: scaleX(0);
            }

            100% {
                transform: scaleX(1);
            }
        }

        .welcome-screen-state-loop #welcome-screen-logo-cover {
            animation: welcome-screen-loop-logo-cover 2200ms infinite ease-in-out;
            opacity: 0.85;
        }

        @keyframes welcome-screen-loop-logo-cover {
            0% {
                transform: translateX(-120px)
            }

            50% {
                transform: translateX(120px)
            }

            100% {
                transform: translateX(120px)
            }
        }
    </style>
    <div id="welcome-screen-background"></div>
    <div id="welcome-screen-foreground">
        <div id="welcome-screen-logo">
            <img id="welcome-screen-logo-image" src="https://static.wixstatic.com/media/b00c1b_38beb4aed07648d2b78b93a0ffa44eb7~mv2.png/v1/fill/w_199,h_240,al_c,usm_0.66_1.00_0.01/b00c1b_38beb4aed07648d2b78b93a0ffa44eb7~mv2.png" alt="">
            <div id="welcome-screen-logo-cover"></div>
        </div>
    </div>
    <script>
        (function createController() {
            let closeRequested = false;
            window.requestCloseWelcomeScreen = () => {
                closeRequested = true;
            };
            const phaseStatic = 'static';
            const phaseBackgroundIntro = 'bg-intro';
            const phaseLogoIntro = 'logo-intro';
            const phaseLoop = 'loop';
            const phaseOutro = 'outro';
            const rootNode = document.getElementById('welcome-screen');
            const backgroundNode = document.getElementById('welcome-screen-background');
            const logoNode = document.getElementById('welcome-screen-logo');
            rootNode.addEventListener('touchstart', (event) => event.preventDefault());

            function sleep(ms) {
                return new Promise((done) => setTimeout(done, ms));
            }

            function onAnimationEnd(node) {
                return new Promise((done) => node.addEventListener('animationend', done, {
                    once: true
                }));
            }

            function onAnimationIteration(node, breakCondition) {
                return new Promise((done) => {
                    const listener = () => {
                        if (breakCondition()) {
                            node.removeEventListener('animationiteration', listener);
                            done();
                        }
                    };
                    node.addEventListener('animationiteration', listener);
                });
            }

            function setPhase(stateName) {
                rootNode.className = `welcome-screen-state-${stateName}`;
            }

            function playStatic() {
                setPhase(phaseStatic);
            }

            function playBackgroundIntro() {
                setPhase(phaseBackgroundIntro);
                return onAnimationEnd(backgroundNode);
            }

            function playLogoIntro() {
                setPhase(phaseLogoIntro);
                return onAnimationEnd(logoNode);
            }

            function playIntro() {
                return playBackgroundIntro().then(playLogoIntro);
            }

            function playOutro() {
                setPhase(phaseOutro);
                return onAnimationEnd(backgroundNode);
            }

            function playLoopUntilCloseRequested() {
                setPhase(phaseLoop);
                return onAnimationIteration(logoNode, () => closeRequested);
            }

            function playIntroAndOutro() {
                return playIntro()
                    .then(() => sleep(500))
                    .then(() => playOutro())
                    .then(() => sleep(1000))
                    .then(() => playStatic());
            }

            function play() {
                return playIntro()
                    .then(() => sleep(1500))
                    .then(() => (closeRequested ? null : playLoopUntilCloseRequested()))
                    .then(() => playOutro())
                    .then(() => rootNode.remove());
            }
            return {
                play,
                playStatic,
                playLogoIntro,
                playIntro,
                playIntroAndOutro,
            };
        })().play();
    </script>
</div>