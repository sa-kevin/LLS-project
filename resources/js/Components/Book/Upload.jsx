// resources/js/Components/Upload.jsx
import React, { useState } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { useForm } from '@inertiajs/inertia-react';

export default function Upload({ url }) {
  const [file, setFile] = useState(null);
  const { post, processing, errors } = useForm();

  const handleFileChange = (e) => {
    setFile(e.target.files[0]);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (!file) {
      alert('Please select a file');
      return;
    }

    const formData = new FormData();
    formData.append('csv_file', file);

    post(url, formData);
  };

  return (
    <form onSubmit={handleSubmit}>
      <div className="mb-4">
        <label
          className="block text-gray-700 text-sm font-bold mb-2"
          htmlFor="csv_file"
        >
          Select CSV File
        </label>
        <input
          type="file"
          className="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="csv_file"
          onChange={handleFileChange}
          accept=".csv,.txt"
        />
        {errors.csv_file && (
          <div className="text-red-500">{errors.csv_file}</div>
        )}
      </div>
      <button
        type="submit"
        className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        disabled={processing}
      >
        {processing ? 'Uploading...' : 'Upload and Process'}
      </button>
    </form>
  );
}
