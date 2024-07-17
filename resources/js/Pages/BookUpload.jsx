// import React from 'react';
// import { Head } from '@inertiajs/react';
// import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

// export default function BookUpload({ auth }) {
//   const handleSubmit = (e) => {
//     e.preventDefault();
//     const formData = new FormData(e.target);
//     fetch(route('upload.process'), {
//       method: 'POST',
//       body: formData,
//     })
//       .then((response) => response.json())
//       .then((data) => {
//         if (data.success) {
//           alert('File uploaded successfully');
//         } else {
//           alert('Upload failed');
//         }
//       })
//       .catch((error) => {
//         console.error('Error:', error);
//         alert('An error occurred');
//       });
//   };

//   return (
//     <AuthenticatedLayout
//       user={auth.user}
//       header={
//         <h2 className="font-semibold text-xl text-gray-800 leading-tight">
//           CSV Upload
//         </h2>
//       }
//     >
//       <Head title="CSV Upload" />

//       <div className="py-12">
//         <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
//           <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
//             <div className="p-6 bg-white border-b border-gray-200">
//               <form onSubmit={handleSubmit}>
//                 <input type="file" name="csv_file" accept=".csv" required />
//                 <button
//                   type="submit"
//                   className="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
//                 >
//                   Upload CSV
//                 </button>
//               </form>
//             </div>
//           </div>
//         </div>
//       </div>
//     </AuthenticatedLayout>
//   );
// }
import React, { useState } from 'react';
import { Head, router, useForm } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { route } from 'ziggy-js';

export default function BookUpload({ auth }) {
  const [selectedFile, setSelectedFile] = useState(null);
  const { data, setData, post, processing, errors } = useForm({
    csv_file: null,
  });

  const handleFileChange = (e) => {
    const file = e.target.files[0];
    setData('csv_file', file);
    setSelectedFile(file ? file.name : null);
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    router.post(route('upload.process'), data, {
      forceFormData: true,
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
        alert('File uploaded successfully');
        setSelectedFile(null);
        setData('csv_file', null);
      },
      onError: (errors) => {
        alert(errors.csv_file || 'Upload failed');
      },
    });
  };

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
          CSV Upload
        </h2>
      }
    >
      <Head title="CSV Upload" />

      <div className="py-12">
        <div className="max-w-2xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 bg-white border-b border-gray-200">
              <form className="space-y-6" onSubmit={handleSubmit}>
                <div className="mb-4">
                  <label
                    htmlFor="csv_file"
                    className="block text-sm font-medium text-gray-700"
                  >
                    Choose CSV file
                  </label>
                  <div className="mt-1 flex flex-col items-center">
                    <label className="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                      <svg
                        className="w-8 h-8"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                      >
                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                      </svg>
                      <span className="mt-2 text-base leading-normal">
                        Select file
                      </span>
                      <input
                        id="csv_file"
                        name="csv_file"
                        type="file"
                        accept=".csv"
                        required
                        className="sr-only"
                        onChange={handleFileChange}
                      />
                    </label>
                    <span className="mt-8 text-base text-gray-600">
                      {selectedFile ? selectedFile : 'No file chosen'}
                    </span>
                  </div>
                  {errors.csv_file && (
                    <div className="text-red-500 text-sm mt-1">
                      {errors.csv_file}
                    </div>
                  )}
                </div>
                <div className="flex justify-end">
                  <button
                    type="submit"
                    className="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    disabled={processing}
                  >
                    {processing ? 'Uploading...' : 'Upload CSV'}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
