// Função principal para realizar requisições HTTP
function HTTP(url, method, data) {
    // Encaminha a chamada para a função makeRequest
    return HTTP.makeRequest(url, method, data);
}

// Função interna para realizar a requisição XMLHttpRequest
HTTP.makeRequest = function(url, method, data) {
    return new Promise((resolve, reject) => {
        // Cria uma instância do objeto XMLHttpRequest
        const xhr = new XMLHttpRequest();
        // Configura a requisição com o método, URL e assíncrona (true)
        xhr.open(method.toUpperCase(), url, true);

        // Verifica se os dados contêm arquivos
        if (containsFiles(data)) {
            // Se contiver arquivos, utiliza FormData para enviar os dados
            const formData = new FormData();
            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    if (data[key] instanceof FileList) {
                        // Se for uma lista de arquivos, adiciona cada arquivo ao FormData
                        for (let i = 0; i < data[key].length; i++) {
                            formData.append(key + '[]', data[key][i]);
                        }
                    } else {
                        // Adiciona outros tipos de dados ao FormData
                        formData.append(key, data[key]);
                    }
                }
            }
            // Envia a requisição com FormData
            xhr.send(formData);
        } else {
            // Se não houver arquivos, configura o cabeçalho para JSON e envia como string JSON
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.send(JSON.stringify(data));
        }

        // Configura os eventos de carga e erro da requisição
        xhr.onload = function () {
            // Chama a função handleResponse para tratar a resposta do servidor
            handleResponse(xhr, resolve, reject);
        };

        xhr.onerror = function () {
            // Rejeita a Promise em caso de erro de conexão
            reject('Erro de conexão');
        };
    });
};

// Função auxiliar para verificar se o objeto contém arquivos
function containsFiles(data) {
    for (const key in data) {
        if (data.hasOwnProperty(key) && (data[key] instanceof File || data[key] instanceof FileList)) {
            return true;
        }
    }
    return false;
}

// Função auxiliar para tratar a resposta do servidor
function handleResponse(xhr, resolve, reject) {
    if (xhr.status >= 200 && xhr.status < 300) {
        try {
            // Tenta fazer o parse da resposta JSON
            const responseObject = JSON.parse(xhr.responseText);
            // Resolve a Promise com o objeto parseado
            resolve(responseObject);
        } catch (error) {
            // Se houver erro no parse, rejeita a Promise
            reject(`Erro ao fazer o parse do JSON: ${error.message}`);
        }
    } else {
        // Se o status da resposta estiver fora do intervalo 200-299, rejeita a Promise
        reject(`Erro: ${xhr.status} - ${xhr.statusText}`);
    }
}

// Método adicional para simplificar chamadas HTTP com método GET
HTTP.get = function(url) {
    return HTTP.makeRequest(url, 'GET');
};

// Método adicional para simplificar chamadas HTTP com método POST
HTTP.post = function(url, data) {
    return HTTP.makeRequest(url, 'POST', data);
};

// Método adicional para simplificar chamadas HTTP com método PUT
HTTP.put = function(url, data) {
    return HTTP.makeRequest(url, 'PUT', data);
};

// Método adicional para simplificar chamadas HTTP com método DELETE
HTTP.delete = function(url, data) {
    return HTTP.makeRequest(url, 'DELETE', data);
};
