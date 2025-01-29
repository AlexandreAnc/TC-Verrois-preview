    const consulterButton = document.getElementById('consulter');
    consulterButton.addEventListener('click', function () {
      const targetId = this.dataset.target;
      const targetElement = document.querySelector(targetId);
      if (targetElement) {
        targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });

  
