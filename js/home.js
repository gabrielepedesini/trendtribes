// // sale counter

// const heroSubtitle = document.querySelector('.hero-subtitle');

// if (heroSubtitle.classList.contains('hero-counter')) {

//     const counter = document.querySelector('.display-counter');

//     if (heroSubtitle.classList.contains('date')) {

//         var dateString = counter.textContent;
    
//         var parts = dateString.split('-');
//         var year = parseInt(parts[0]);
//         var month = parseInt(parts[1]) - 1;
//         var day = parseInt(parts[2]);
    
//         var endDate = new Date(year, month, day, 23, 59, 59);
    
//         var localOffset = new Date().getTimezoneOffset() * 60000; 
//         endDate = new Date(endDate.getTime() - localOffset);
    
//         function updateCountdown() {
            
//             var now = new Date();
//             var timeDifference = endDate.getTime() - now.getTime();
    
//             var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
//             var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//             var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
//             var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);
    
//             if (timeDifference > 0) {
//                 if (days === 0) {
//                     counter.innerHTML = hours + "h " + minutes + "m " + seconds + "s";
//                 } else if (days === 0 && hours === 0) {
//                     counter.innerHTML = minutes + "m " + seconds + "s";
//                 } else if (days === 0 && hours === 0 && minutes === 0) {
//                     counter.innerHTML = seconds + "s";
//                 } else {
//                     counter.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
//                 }
//                 setTimeout(updateCountdown, 1000);
//             } else {
//                 counter.innerHTML = "Countdown expired";
//             }
//         }
    
//         updateCountdown();
    
//     } else {

//         var now = new Date();

//         var endDate = new Date(now);
//         endDate.setDate(endDate.getDate() + 1);
//         endDate.setHours(0, 0, 0, 0);

//         function updateCountdown() {
//             var now = new Date();

//             var timeDifference = endDate.getTime() - now.getTime();

//             var days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
//             var hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
//             var minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
//             var seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

//             if (timeDifference > 0) {
//                 if (days === 0) {
//                     counter.innerHTML = hours + "h " + minutes + "m " + seconds + "s";
//                 } else if (days === 0 && hours === 0) {
//                     counter.innerHTML = minutes + "m " + seconds + "s";
//                 } else if (days === 0 && hours === 0 && minutes === 0) {
//                     counter.innerHTML = seconds + "s";
//                 } else {
//                     counter.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
//                 }
//                 setTimeout(updateCountdown, 1000);
//             } else {
                
//                 endDate.setDate(endDate.getDate() + 1);
//                 endDate.setHours(0, 0, 0, 0);
//                 setTimeout(updateCountdown, 1000);
//             }
//         }

//         updateCountdown();

//     }
// }