// Requisições para a api
document.getElementById('imgInput').addEventListener('change', function() {
  var files = this.files;

  if (files.length !== 1) {
    alert('Por favor, selecione apenas um arquivo.');
    this.value = ''; // Limpa a seleção dos arquivos
    return;
  }
})


function displayFileName() {
  const fileInput = document.getElementById('imgInput');
  const fileNameDisplay = document.getElementById('fileName');
  const fileName = fileInput.files[0] ? fileInput.files[0].name : '';
  fileNameDisplay.textContent = `${fileName}`;
  console.log('aqui')
}

function fetchDataFromAPI(userEmail) {
    const apiUrl = `http://localhost:8080/backend/api.php?email=${userEmail}`;
  
    fetch(apiUrl)
      .then(response => {
        if (!response.ok) {
          if (response.status === 404) {

            const defaultData = {
              name: 'Seu nome aqui',
              age: 'Sua idade',
              address: 'Sua rua',
              neighborhood: 'Seu bairro',
              state: 'Seu estado',
              zipCode: 'Seu CEP',
              biography: 'Sua biografia'
            };

            updateElementsWithDefaultData(defaultData);
          }
        }
        return response.json();
      })
      .then(data => {
        // Se não houver erro, atualiza os elementos com os dados da API
        const userData = data[0];
        const neighborhoodAndState = `${userData.neighborhood} - ${userData.state}`;
        console.log(userData);
        updateElementsWithData(userData, neighborhoodAndState);
      })
      .catch(error => {
        console.error('Erro:', error.message);
      });
}
  
// Função para atualizar os elementos com os dados padrão
function updateElementsWithDefaultData(defaultData) {
    document.getElementById('name').textContent = defaultData.name;
    document.getElementById('age').textContent = defaultData.age;
    document.getElementById('address').textContent = defaultData.address;
    document.getElementById('ufData').textContent = defaultData.neighborhood + ' - ' + defaultData.state;
    document.getElementById('biography').textContent = defaultData.biography;
}
  
// Função para atualizar os elementos com os dados da API
function updateElementsWithData(userData, neighborhoodAndState) {
    document.getElementById('profile').src = userData.profile || '';
    document.getElementById('name').textContent = userData.name;
    document.getElementById('age').textContent = userData.age;
    document.getElementById('address').textContent = userData.address;
    document.getElementById('ufData').textContent = neighborhoodAndState;
    document.getElementById('biography').textContent = userData.biography;

    const nameInput = document.getElementById('inputName');
    const ageInput = document.getElementById('ageInput');
    const addressInput = document.getElementById('streetInput');
    const neighborhoodInput = document.getElementById('neighborhoodInput');
    const stateInput = document.getElementById('ufInput');
    const zipCodeInput = document.getElementById('zipCodeInput');
    const biographyInput = document.getElementById('bioInput');
  
    // Define os valores dos inputs com os dados obtidos da API
    nameInput.value = userData.name;
    ageInput.value = userData.age;
    addressInput.value = userData.address;
    neighborhoodInput.value = userData.neighborhood;
    stateInput.value = userData.state;
    zipCodeInput.value = userData.zipCode;
    biographyInput.value = userData.biography;
}

// Variável global para armazenar o email
let userEmail = '';

document.addEventListener('DOMContentLoaded', function() {

    // Seleciona o pop-up
    const popupOverlay = document.getElementById('popup-overlay');
    const popupInput = document.querySelector('#popup input[type="email"]');
    const closeButton = document.getElementById('close-popup');
  
    // Função para validar o formato do email
    function isValidEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }
  
    document.addEventListener('click', function(event) {
      if (!popupOverlay.contains(event.target) && popupOverlay.style.display === 'block') {
        if (!userEmail || userEmail.trim() === '') {
          alert('Por favor, insira seu email antes de sair.');
          event.stopPropagation();
        }
      }
    });
  
    closeButton.addEventListener('click', function() {
      // Verifica se o campo de email está preenchido e tem um formato válido
      if (popupInput.value.trim() !== '') {
        if (isValidEmail(popupInput.value.trim())) {

            userEmail = popupInput.value.trim();
            
            console.log('Email inserido:', userEmail);

            fetchDataFromAPI(userEmail);

            popupOverlay.style.display = 'none';

        } else {
          alert('Por favor, insira um email válido.');
        }
      } else {
        alert('Por favor, insira seu email antes de enviar.');
      }
    });
});

function sendDataToAPI() {
    const name = document.getElementById('inputName').value.trim();
    const age = document.getElementById('ageInput').value.trim();
    const address = document.getElementById('streetInput').value.trim();
    const neighborhood = document.getElementById('neighborhoodInput').value.trim();
    const zipCode = document.getElementById('zipCodeInput').value.trim();
    const state = document.getElementById('ufInput').value.trim();
    const biography = document.getElementById('bioInput').value.trim();
    const fileInput = document.getElementById('imgInput');
    const profile = fileInput.files[0]; 
    const email = userEmail;

    
    if (!name || !age || !address || !neighborhood || !zipCode || !state || !biography) {

      alert("Por favor, preencha todos os campos obrigatórios");
      return; // Sai da função para evitar o envio de dados incompletos
  }

    sendDataToUpdateAPI(email,name,age, profile,address, neighborhood, zipCode, state,biography)
    .then(response => {
      // Se não houver erro, o registro foi atualizado com sucesso
      console.log('Registro atualizado com sucesso:', response);
    })
    .catch(error => {
      console.log('Erro encontrado na APi', error);      
    });
}

// Adiciona um evento de envio ao formulário para capturar o envio dos dados
document.addEventListener('DOMContentLoaded', function() {
  // Seu código aqui
  document.querySelector('form').addEventListener('submit', function(event) {
      event.preventDefault(); 
      sendDataToAPI(); 
  });
});

function sendDataToUpdateAPI(email, name, age, profile, address, neighborhood, zipCode, state, biography) {
  return new Promise((resolve, reject) => {
  const formData = new FormData();
  formData.append('email', email);
  formData.append('name', name);
  formData.append('age', age);
  formData.append('address', address);
  formData.append('neighborhood', neighborhood);
  formData.append('zipCode', zipCode);
  formData.append('state', state);
  formData.append('biography', biography);
  // Verifica se o perfil não é nulo
  if (!profile) {
    console.log('O perfil não foi alterado. Não será enviado para a API.');
  } else{
    console.log(profile);
    formData.append('profile', profile);
  }    
  
  const jsonData = {
    email: email,
    name: name,
    age: age,
    address: address,
    neighborhood: neighborhood,
    zipCode: zipCode,
    state: state,
    biography: biography,
  };
  
  if (profile) {
    jsonData.profile = profile;
  }

  const apiUrl = `http://localhost:8080/backend/api.php?email=${userEmail}`;
  console.log(jsonData);
  // Faz a solicitação PUT para a rota da API
  fetch(apiUrl, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(jsonData) // Passa o objeto JSON como corpo da solicitação
    })
    .then(response => {
      if (!response.ok) {
          // Se ocorrer um erro HTTP, verifica se é erro 404
          if (response.status === 404) {
              console.log('Erro 404: Registro não encontrado. Não será feita a atualização.');
              sendDataToCreateAPI(email, name, age, profile, address, neighborhood, zipCode, state, biography);
              return; // Não faz a atualização e encerra a função
          }
      }
      return response.json();
    })
    .then(responseData => {
      // Lida com a resposta da API, se necessário
      console.log('Resposta da API:', responseData);
    })
    .catch(error => {
      console.error('Erro:', error.message);
      alert('Ocorreu um erro ao enviar dados para a API. Por favor, tente novamente mais tarde.');
    });
  })
}


function sendDataToCreateAPI(email, name, age,profile, address, neighborhood, zipCode, state, biography) {

    // Cria um objeto FormData e adiciona os dados do formulário e o arquivo
    const formData = new FormData();
    if (!profile) {
      console.log('O perfil não foi alterado. Não será enviado para a API.');
      return; // Retorna imediatamente se o perfil for nulo
    } else{
      formData.append('profile', profile);
    }
    formData.append('name', name);
    formData.append('email', email);
    formData.append('age', age);
    formData.append('address', address);
    formData.append('neighborhood', neighborhood);
    formData.append('zipCode', zipCode);
    formData.append('state', state);
    formData.append('biography', biography);
  
    const jsonData = {
      email: email,
      name: name,
      age: age,
      address: address,
      neighborhood: neighborhood,
      zipCode: zipCode,
      state: state,
      biography: biography,
    };
    
    if (profile) {
      jsonData.profile = profile;
    }
    // Faz a solicitação POST para a rota da API
    fetch('http://localhost:8080/backend/api.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(jsonData)// Passa o objeto JSON como corpo da solicitação
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Erro ao enviar dados para a API');
      }
      return response.json();
    })
    .then(responseData => {
      // Lida com a resposta da API, se necessário
      console.log('Resposta da API:', responseData);
      alert('Dados criados com sucesso.');
    })
    .catch(error => {
      console.error('Erro:', error.message);
    });
  }
  
